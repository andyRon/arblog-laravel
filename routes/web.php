<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/blog');
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


Route::get('/blog', [BlogController::class, 'index'])->name('blog.home');
Route::get('/blog/{slug}', [BlogController::class, 'showPost'])->name('blog.detail');

// 后台路由
Route::get('/admin', function () {
    return redirect('/admin/post');
});
Route::middleware('auth')->group(function () {
    Route::resource('admin/post', PostController::class);
    Route::resource('admin/tag', TagController::class, ['except' => 'show']);
    Route::get('admin/upload', [UploadController::class, 'index']);
    
    Route::post('admin/upload/file', [UploadController::class, 'uploadFile']);
    Route::delete('admin/upload/file', [UploadController::class, 'deleteFile']);
    Route::post('admin/upload/folder', [UploadController::class, 'createFolder']);
    Route::delete('admin/upload/folder', [UploadController::class, 'deleteFolder']);
});

// 登录退出
//Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
//Route::post('/login', 'Auth\LoginController@login');
//Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
