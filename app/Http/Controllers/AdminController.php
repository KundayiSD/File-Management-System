<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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

        return redirect('/admin/login');
    }////End Method

    public function AdminLogin(){
        return view('admin.admin_login');
    }
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

}
