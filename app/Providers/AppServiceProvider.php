<?php

namespace App\Providers;


use App\Models\Favicon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings;
use App\Models\Logo;
use App\Models\MenuBlog;
use App\Models\MenuDichVu;
use App\Models\MenuReview;
use App\Models\TheLoai;
use App\Models\WebConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('notifications', Auth::user()->notifications->take(5));
                $view->with('unreadCount', Auth::user()->unreadNotifications->count());
            }
        });

        View::composer('*', function ($view) {
            if (request()->is('admin/*')) {
                return; // Nếu đang vào admin thì bỏ qua
            }
            $logo = Logo::first();
            $favicon = Favicon::first();
            $info = WebConfig::first();
            $settings = Settings::first();
            $menu = TheLoai::whereNull('parent_id') // Chỉ lấy menu cha
                ->with('submenu')
                ->orderBy('position') // Sắp xếp theo vị trí
                ->get();
            $menu_dv = MenuDichVu::whereNull('parent_id') // Chỉ lấy menu cha
                ->with('submenu')
                ->orderBy('position') // Sắp xếp theo vị trí
                ->get();
            $menu_review = MenuReview::whereNull('parent_id') // Chỉ lấy menu cha
                ->with('submenu')
                ->orderBy('position') // Sắp xếp theo vị trí
                ->get();
            $menu_blog = MenuBlog::whereNull('parent_id') // Chỉ lấy menu cha
                ->with('submenu')
                ->orderBy('position') // Sắp xếp theo vị trí
                ->get();
            $web_config = WebConfig::first();


            $view->with([
                'logo' => $logo,
                'favicon' => $favicon,
                'info' => $info,
                'settings' => $settings,
                'menu' => $menu,
                'menu_dv' => $menu_dv,
                'menu_review' => $menu_review,
                'menu_blog' => $menu_blog,
                'web_config' => $web_config
            ]);
        });
        View::composer('*', function ($view) {
            $settings = Settings::first();
            $view->with('analytics', $settings ? $settings->getAnalyticsScript() : null);
        });
    }
}
