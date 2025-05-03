<?php

use App\Http\Controllers\Admin\WebConfigController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReviewController;
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
use App\Http\Controllers\FaviconController;
use App\Http\Controllers\LienHeController;
use App\Http\Controllers\MenuBlogController;
use App\Http\Controllers\MenuReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SlideController;
use Faker\Provider\Lorem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    Route::get('/admin/get-subcategories/{parent_id}', function ($parent_id) {
        $subcategories = App\Models\TheLoai::where('parent_id', $parent_id)->get();
        return response()->json(['subcategories' => $subcategories]);
    })->name('get.subcategories');

    Route::get('/admin/get-blog-subcategories/{parent_id}', function ($parent_id) {
        $subcategories = App\Models\MenuBlog::where('parent_id', $parent_id)->get();
        return response()->json(['subcategories' => $subcategories]);
    })->name('get.blog-subcategories');

    Route::get('/admin/get-dichvu-subcategories/{parent_id}', function ($parent_id) {
        $subcategories = App\Models\MenuDichVu::where('parent_id', $parent_id)->get();
        return response()->json(['subcategories' => $subcategories]);
    })->name('get.dichvu-subcategories');

    Route::get('/admin/get-review-subcategories/{parent_id}', function ($parent_id) {
        $subcategories = App\Models\MenuReview::where('parent_id', $parent_id)->get();
        return response()->json(['subcategories' => $subcategories]);
    })->name('get.review-subcategories');


    ///////////   audioS   /////////////////////////
    Route::get('/admin/audio', [AudioController::class, 'index'])->name('audio.index');
    Route::get('/admin/add-audio', [AudioController::class, 'add'])->name('audio.add');
    Route::post('/admin/addaudio', [AudioController::class, 'store'])->name('audio.store');
    Route::get('/admin/audio-detail/{id}', [AudioController::class, 'show_update'])->name('audio.show-update');
    Route::delete('/admin/audio/{id}', [AudioController::class, 'destroy'])->name('audio.destroy');
    Route::put('/admin/audio/{id}', [AudioController::class, 'update'])->name('audio.update');
    Route::put('/admin/audio-status/{id}', [AudioController::class, 'update_status'])->name('audio.update_status');
    Route::post('/admin/delete-all', [AudioController::class, 'deleteAll'])->name('audio.deleteAll');
    Route::post('/admin/audio/update-order', [AudioController::class, 'updateOrder'])->name('audio.updateOrder');
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
    Route::post('/admin/dichvu/update-order', [DichVuController::class, 'updateOrder'])->name('dichvu.updateOrder');


    //////////////////    MENU review  ////////////////////////////////////
    Route::get('/admin/menu-review', [MenuReviewController::class, 'index'])->name('menu-review.index');
    Route::post('/admin/addMenu-review', [MenuReviewController::class, 'store'])->name('menu-review.store');
    Route::delete('/admin/menu-review/{id}', [MenuReviewController::class, 'destroy'])->name('menu-review.destroy');
    Route::put('/admin/menu-review/{id}', [MenuReviewController::class, 'update'])->name('menu-review.update');
    Route::post('/admin/addsubmenu-review', [MenuReviewController::class, 'addSub'])->name('menu-review.addSub');
    Route::post('/admin/updateOrder-review', [MenuReviewController::class, 'updateOrder'])->name('menu-review.updateOrder');
    Route::get('/admin/submenu-review/{id}', [MenuReviewController::class, 'submenu'])->name('menu-review.submenu');
    ///////////   review   /////////////////////////
    Route::get('/admin/review', [AdminReviewController::class, 'index'])->name('admin_review.index');
    Route::get('/admin/add-review', [AdminReviewController::class, 'add'])->name('admin_review.add');
    Route::post('/admin/add-review', [AdminReviewController::class, 'store'])->name('admin_review.store');
    Route::get('/admin/review-detail/{id}', [AdminReviewController::class, 'show_update'])->name('admin_review.show-update');
    Route::delete('/admin/review/{id}', [AdminReviewController::class, 'destroy'])->name('admin_review.destroy');
    Route::put('/admin/review/{id}', [AdminReviewController::class, 'update'])->name('admin_review.update');
    Route::put('/admin/review-status/{id}', [AdminReviewController::class, 'update_status'])->name('admin_review.update_status');
    Route::post('/admin/delete-all-review', [AdminReviewController::class, 'deleteAll'])->name('admin_review.deleteAll');
    Route::post('/admin/review/update-order', [AdminReviewController::class, 'updateOrder'])->name('review.updateOrder');


    //////////////////    MENU blog  ////////////////////////////////////
    Route::get('/admin/menu-blog', [MenuBlogController::class, 'index'])->name('menu-blog.index');
    Route::post('/admin/addMenu-blog', [MenuBlogController::class, 'store'])->name('menu-blog.store');
    Route::delete('/admin/menu-blog/{id}', [MenuBlogController::class, 'destroy'])->name('menu-blog.destroy');
    Route::put('/admin/menu-blog/{id}', [MenuBlogController::class, 'update'])->name('menu-blog.update');
    Route::post('/admin/addsubmenu-blog', [MenuBlogController::class, 'addSub'])->name('menu-blog.addSub');
    Route::post('/admin/updateOrder-blog', [MenuBlogController::class, 'updateOrder'])->name('menu-blog.updateOrder');
    Route::get('/admin/submenu-blog/{id}', [MenuBlogController::class, 'submenu'])->name('menu-blog.submenu');
    ///////////   blog   /////////////////////////
    Route::get('/admin/blog', [AdminBlogController::class, 'index'])->name('admin_blog.index');
    Route::get('/admin/add-blog', [AdminBlogController::class, 'add'])->name('admin_blog.add');
    Route::post('/admin/add-blog', [AdminBlogController::class, 'store'])->name('admin_blog.store');
    Route::get('/admin/blog-detail/{id}', [AdminBlogController::class, 'show_update'])->name('admin_blog.show-update');
    Route::delete('/admin/blog/{id}', [AdminBlogController::class, 'destroy'])->name('admin_blog.destroy');
    Route::put('/admin/blog/{id}', [AdminBlogController::class, 'update'])->name('admin_blog.update');
    Route::put('/admin/blog-status/{id}', [AdminBlogController::class, 'update_status'])->name('admin_blog.update_status');
    Route::post('/admin/delete-all-blog', [AdminBlogController::class, 'deleteAll'])->name('admin_blog.deleteAll');
    Route::post('/admin/blog/update-order', [AdminBlogController::class, 'updateOrder'])->name('blog.updateOrder');

    //////////////////////          LOGO               ////////////////////////////
    Route::get('/admin/logo', [LogoController::class, 'index'])->name('logo');
    Route::post('/admin/logo', [LogoController::class, 'store'])->name('logo.store');
    Route::get('/admin/favicon', [FaviconController::class, 'index'])->name('favicon');
    Route::post('/admin/favicon', [FaviconController::class, 'store'])->name('favicon.store');

    //////////////////////       SLIDES           ////////////////////////////
    Route::get('/admin/slide', [SlideController::class, 'index'])->name('slide.index');
    Route::get('/admin/add-slide', [SlideController::class, 'add'])->name('slide.add');
    Route::post('/admin/addSlide', [SlideController::class, 'store'])->name('slide.store');
    Route::delete('/admin/slide/{id}', [SlideController::class, 'destroy'])->name('slide.destroy');
    Route::put('/admin/slide-status/{id}', [SlideController::class, 'update_status'])->name('slide.update_status');

    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings', [SettingsController::class, 'store'])->name('settings.store');
    Route::get('/web-config', [WebConfigController::class, 'index'])->name('web-config.index');
    Route::post('/web-config/store', [WebConfigController::class, 'store'])->name('web-config.store');
    Route::get('/admin/seo-page', function () {
        return app(AdminController::class)->seo();
    })->name('seo');
    Route::get('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->unreadNotifications->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    })->name('notifications.markAsRead');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

Route::post('/send-contact-mail', [HomeController::class, 'sendContactMail']);
$excludeSlugs = ['admin', 'about', 'contact', 'blog'];
Route::get('/', function () {
    return app(HomeController::class)->index();
})->name('home');
Route::post('/', [HomeController::class, 'handleForm'])->name('submit.form');
Route::get('/detail-TMa', [DetailTMaController::class, 'index'])->name('detailTMa.index');
Route::get('/podcast', [AllTMaController::class, 'index'])->name('allTMa.index');
Route::get('/podcast/{slug?}', [AllTMaController::class, 'phanloai'])->name('allTMa.theloai');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogTMa.index');
Route::get('/blogs/{slug}', [BlogController::class, 'phanloai'])->name('blogTMa');
Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
Route::get('/reviews/{slug}', [ReviewController::class, 'phanloai'])->name('reviews');
Route::get('/review/{slug}', [ReviewController::class, 'detail'])->name('review.detail');

Route::get('/lienhe', [LienHeController::class, 'index'])->name('lienhe.index');
Route::get('/dvsx', [DichVuSXController::class, 'index'])->name('dvsx.index');
Route::get('/dich-vu-san-xuat/{slug}', [DichVuSXController::class, 'phanloai'])->name('dvsx');
Route::get('/dich-vu/{slug}', [DichVuSXController::class, 'detail'])->name('dvsx.detail');

Route::get('/blog/{slug}', [BlogDetailController::class, 'index'])->name('blogdetail');

Route::get('/{slug}', [HomeController::class, 'detail'])->where('slug', '^(?!admin|blog|about|contact).*')->name('detail');
Route::post('/audio/play/{id}', [AudioController::class, 'playAudio']);
