<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AllTMaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\MenuAudioController;
use App\Http\Controllers\MenuDichVuController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogDetailController;
use App\Http\Controllers\DetailTMaController;
use App\Http\Controllers\DichVuSXController;
use App\Http\Controllers\LienHeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SlideController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';



Route::get('/admin', function () {
    return app(AdminController::class)->index();
})->middleware(['auth', 'verified'])->name('admin');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/menu', [MenuAudioController::class, 'index'])->name('menu.index');
    Route::post('/admin/addMenu', [MenuAudioController::class, 'store'])->name('menu.store');
    Route::delete('/admin/menu/{id}', [MenuAudioController::class, 'destroy'])->name('menu.destroy');
    Route::put('/admin/menu/{id}', [MenuAudioController::class, 'update'])->name('menu.update');
    Route::post('/admin/addsubmenu', [MenuAudioController::class, 'addSub'])->name('menu.addSub');
    Route::post('/admin/updateOrder', [MenuAudioController::class, 'updateOrder'])->name('menu.updateOrder');
    Route::get('/admin/submenu/{id}', [MenuAudioController::class, 'submenu'])->name('menu.submenu');
    Route::get('/get-subcategories', [MenuAudioController::class, 'getSubcategories']);


    ///////////   audioS   /////////////////////////
    Route::get('/admin/audio', [AudioController::class, 'index'])->name('audio.index');
    Route::get('/admin/add-audio', [AudioController::class, 'add'])->name('audio.add');
    Route::post('/admin/addaudio', [AudioController::class, 'store'])->name('audio.store');
    Route::get('/admin/audio-detail/{id}', [AudioController::class, 'show_update'])->name('audio.show-update');
    Route::delete('/admin/audio/{id}', [AudioController::class, 'destroy'])->name('audio.destroy');
    Route::put('/admin/audio/{id}', [AudioController::class, 'update'])->name('audio.update');
    Route::put('/admin/audio-status/{id}', [AudioController::class, 'update_status'])->name('audio.update_status');
    Route::post('/admin/delete-all', [AudioController::class, 'deleteAll'])->name('audio.deleteAll');
    Route::get('/get-audio', [AudioController::class, 'getaudios'])->name('get-audio');



    //////////////////    MENU dichvu  ////////////////////////////////////
    Route::get('/admin/menu-dichvu', [MenuDichVuController::class, 'index'])->name('menu-dichvu.index');
    Route::post('/admin/addMenu-dichvu', [MenuDichVuController::class, 'store'])->name('menu-dichvu.store');
    Route::delete('/admin/menu-dichvu/{id}', [MenuDichVuController::class, 'destroy'])->name('menu-dichvu.destroy');
    Route::put('/admin/menu-dichvu/{id}', [MenuDichVuController::class, 'update'])->name('menu-dichvu.update');
    Route::post('/admin/addsubmenu-dichvu', [MenuDichVuController::class, 'addSub'])->name('menu-dichvu.addSub');
    Route::post('/admin/updateOrder-dichvu', [MenuDichVuController::class, 'updateOrder'])->name('menu-dichvu.updateOrder');
    Route::get('/admin/submenu-dichvu/{id}', [MenuDichVuController::class, 'submenu'])->name('menu-dichvu.submenu');
    ///////////   dichvu   /////////////////////////
    Route::get('/admin/dichvu', [DichVuController::class, 'index'])->name('dichvu.index');
    Route::get('/admin/add-dichvu', [DichVuController::class, 'add'])->name('dichvu.add');
    Route::post('/admin/add-dichvu', [DichVuController::class, 'store'])->name('dichvu.store');
    Route::get('/admin/dichvu-detail/{id}', [DichVuController::class, 'show_update'])->name('dichvu.show-update');
    Route::delete('/admin/dichvu/{id}', [DichVuController::class, 'destroy'])->name('dichvu.destroy');
    Route::put('/admin/dichvu/{id}', [DichVuController::class, 'update'])->name('dichvu.update');
    Route::put('/admin/dichvu-status/{id}', [DichVuController::class, 'update_status'])->name('dichvu.update_status');
    Route::post('/admin/delete-all-dichvu', [DichVuController::class, 'deleteAll'])->name('dichvu.deleteAll');

    //////////////////////          LOGO               ////////////////////////////
    Route::get('/admin/logo', [LogoController::class, 'index'])->name('logo');
    Route::post('/admin/logo', [LogoController::class, 'store'])->name('logo.store');

    //////////////////////       SLIDES           ////////////////////////////
    Route::get('/admin/slide', [SlideController::class, 'index'])->name('slide.index');
    Route::get('/admin/add-slide', [SlideController::class, 'add'])->name('slide.add');
    Route::post('/admin/addSlide', [SlideController::class, 'store'])->name('slide.store');
    Route::delete('/admin/slide/{id}', [SlideController::class, 'destroy'])->name('slide.destroy');
    Route::put('/admin/slide-status/{id}', [SlideController::class, 'update_status'])->name('slide.update_status');


    Route::get('/admin/seo-page', function () {
        return app(AdminController::class)->seo();
    })->name('seo');
});


$excludeSlugs = ['admin', 'about', 'contact', 'blog'];
Route::get('/', function () {
    return app(HomeController::class)->index();
})->name('home');
Route::post('/', [HomeController::class, 'handleForm'])->name('submit.form');
Route::get('/detail-TMa', [DetailTMaController::class, 'index'])->name('detailTMa.index');
Route::get('/all-TMa', [AllTMaController::class, 'index'])->name('allTMa.index');
Route::get('/blog-detail', [BlogDetailController::class, 'index'])->name('blogdetail.index');
Route::get('/blog-TMa', [BlogController::class, 'index'])->name('blogTMa.index');
Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
Route::get('/lienhe', [LienHeController::class, 'index'])->name('lienhe.index');
Route::get('/dvsx', [DichVuSXController::class, 'index'])->name('dvsx.index');
Route::get('/{slug}', [HomeController::class, 'detail'])->where('slug', '^(?!admin|blog|about|contact).*')->name('detail');
Route::post('/audio/play/{id}', [AudioController::class, 'playAudio']);

