<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SecretaryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//if user is not logged in, redirect to login page
Route::get('/', function () {
    return redirect('/login');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
//Admin group middleware
    Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');

    Route::get('admin/manage-users', [AdminController::class, 'manageUsers'])->name('manage-users');
    Route::get('admin/department', [AdminController::class, 'manageDepartments'])->name('departments');
    Route::post('admin/users', [AdminController::class, 'storeUser'])->name('users.store');

    Route::post('/store-department', [AdminController::class, 'storeDepartment'])->name('departments.store');

    Route::get('manage-files', [AdminController::class, 'manageFiles'])->name('manage-files');
    Route::post('admin/files/upload', [AdminController::class, 'upload'])->name('files.upload');
    Route::get('admin/files/download/{file}', [AdminController::class, 'download'])->name('files.download');




Route::patch('/files/{file}', [AdminController::class, 'update'])->name('files.update');
Route::get('admin/files/archive/{file}', [AdminController::class, 'archive'])->name('files.archive');
Route::get('admin/achievd-files', [AdminController::class, 'viewArchivedFiles'])->name('achieved-files');
Route::get('admin/files/unarchive/{file}', [AdminController::class, 'unarchive'])->name('files.unarchive');

Route::get('admin/folders', [AdminController::class, 'viewFolders'])->name('folders');

Route::post('/folders/create', [AdminController::class, 'createFolder'])->name('folders.create');


});//End of Admin Middleware

    Route::middleware(['auth','role:secretary'])->group(function(){
    Route::get('/secretary/dashboard', [SecretaryController::class, 'SecretaryDashboard'])->name('secretary.dashboard');
 });//End of Secretary Middleware

    // Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
