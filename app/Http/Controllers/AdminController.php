<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Folder;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');

    }//End Method

    public function AdminLogout(Request $request){

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }////End Method

    // public function AdminLogin(){
    //     return view('admin.admin_login');
    // }
    public function AdminProfile(){
        $id = Auth::user()->id;
        $profileData =  User::find($id);

        return view('admin.admin_profile_view',compact('profileData'));
    }

    public function AdminProfileStore(Request $request){
       try{

        $id = Auth::user()->id;
        $profileData =  User::find($id);
        $profileData->username = $request->username;
        $profileData->name = $request->name;
        $profileData->email = $request->email;
        $profileData->phone = $request->phone;
        $profileData->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images'.$profileData->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            //dd($filename);

            $file->move(public_path('upload/admin_images/').$filename);
            $profileData['photo'] = $filename;

        }
        $profileData->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


       }
       catch(Exception $exception)
       {
        dd($exception->getMessage());
        return back()->with('error', $exception->getMessage());

       }

    }
    public function AdminChangePassword(){
        $id = Auth::user()->id;
        $profileData =  User::find($id);

        return view('admin.admin_change_password',compact('profileData'));

    }

    public function AdminUpdatePassword(Request $request){
       // $id = Auth::user()->id;
       // $profileData =  User::find($id);
//validation
$request->validate([
    'old_password' => 'required',
    'new_password' => 'required|confirmed',
]);
//match old password
if (!Hash::check($request->old_password, auth::user()->password)){
$notification = array(
    'message' => 'Old Password Does Not Match',
    'alert-type' => 'error'
);
return back()->with($notification);

    }
    //Update the new password
    User::whereId(auth()->user()->id)->update([
        'password' =>
        Hash::make($request->new_password)

    ]);
    $notification = array(
        'message' => 'Password Changed Successfully',
        'alert-type' => 'success'
    );
    return back()->with($notification);
    }

    public function manageUsers(){
        $users = User::all();
        $departments = Department::all();
        return view('admin.manage-users',compact('users',  'departments'));
    }

    public function manageDepartments(){

        $departments = Department::all();
        return view('admin.manage-departments',compact('departments'));
    }

    public function storeDepartment(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50',
        'status' => 'in:active,inactive',
    ]);

    Department::create([
        'name' => $request->input('name'),
        'code' => $request->input('code'),
        'status' => $request->input('status', 'active'),
    ]);

    $notification = array(
        'message' => 'Added Department Successfully',
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
}

public function storeUser(Request $request)
    {
        try {
            // Validate the form data
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'department' => 'nullable|exists:departments,id',
                'role' => 'in:admin,secretary,user',
            ]);

            // Start a database transaction
            DB::beginTransaction();

            // Create a new user
            $user = User::create([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('username')),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'department_id' => $request->input('department'),
                'role' => $request->input('role', 'user'),
            ]);

            // Commit the transaction if all data is saved successfully
            DB::commit();
            $notification = array(
                'message' => 'Added User Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            $notification = array(
                'message' => 'Failed to add user'. $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function manageFiles(){
        $files = File::where('is_achieved', false)->get();
        $folders = Folder::all();
        return view('admin.manage-files',compact('files','folders'));
    }
    public function upload(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx,txt|max:2048', // Adjust the allowed file types and size
            'depa'
        ]);

        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $path = $uploadedFile->storeAs('uploads', $filename); // Store the file in the "storage/app/uploads" directory

        File::create([
            'name' => $request->input('name'),
            'user_id' => auth()->id(), // Assuming you have user authentication
            'path' => $path,
            'folder_id' => $request->input('folder_id'),
        ]);
        $notification = array(
            'message' => 'File uploaded successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function download($file)
    {
        $file = File::find($file);

        if ($file) {
            $filePath = storage_path('app/' . $file->path);

            if (file_exists($filePath)) {
                return response()->download($filePath, $file->name);
            } else {
                return redirect()->back()->with('error', 'File not found.');
            }
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    public function update(Request $request, File $file)
    {
        $request->validate([
            'new_title' => 'required|string|max:255',
        ]);

        $file->update([
            'name' => $request->input('new_title'),
        ]);


        $notification = array(
            'message' => 'File Edited successfully.',
            'alert-type' => 'success'
        );



        return redirect()->back()->with($notification);
    }

    public function archive(File $file)
    {
        // Update the file's status to "inactive" or archive it
        $file->update(['is_achieved' => true]);

        $notification = array(
            'message' => 'File Achieved successfully.',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notification);
    }

    public function viewArchivedFiles(){

        $files = File::where('is_achieved', true)->get();
        return view('admin.achieved-files',compact('files'));

    }

    public function unarchive(File $file)
    {
        // Update the file's status to "active" or unarchive it
        $file->update(['is_achieved' => false]);

        $notification = array(
            'message' => 'File Uarchived successfully.',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notification);
    }

    public function viewFolders(){

        $folders = Folder::all();
        $departments = Department::all();
        return view('admin.folders',compact('folders','departments'));
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Folder::create([
            'name' => $request->input('name'),
            'user_id' => auth()->id(), // Assuming you have user authentication
            'department_id' => $request->input('department_id'),
        ]);

        $notification = array(
            'message' => 'Folder created successfully.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

}
