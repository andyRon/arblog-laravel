<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
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
//    return 'home';
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//
//require __DIR__.'/auth.php';


Route::get('/blog', [BlogController::class, 'index'])->name('blog.home');
Route::get('/blog/{slug}', [BlogController::class, 'showPost'])->name('blog.detail');

// 后台路由
Route::get('/admin', function () {
    return redirect('/admin/post');
});
//Route::middleware('auth')->group(function () {
    Route::resource('admin/post', PostController::class, ['except' => 'show']);
    Route::resource('admin/tag', TagController::class, ['except' => 'show']);
    Route::get('admin/upload', [UploadController::class, 'index']);

    // 上传相关路由
    Route::post('admin/upload/file', [UploadController::class, 'uploadFile']);
    Route::delete('admin/upload/file', [UploadController::class, 'deleteFile']);
    Route::post('admin/upload/folder', [UploadController::class, 'createFolder']);
    Route::delete('admin/upload/folder', [UploadController::class, 'deleteFolder']);
//});
// 登录退出
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
//Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// 联系我们
Route::get('contact', [ContactController::class, 'showForm']);
Route::post('contact', [ContactController::class, 'sendContactInfo']);

Route::get('rss', [BlogController::class, 'rss']);

Route::get('sitemap.xml', [BlogController::class, 'siteMap']);
