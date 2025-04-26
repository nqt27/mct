<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogVisit
{
    /**
     * Xử lý request và ghi nhận lượt truy cập vào database.
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUrl = $request->path();

        // Loại trừ các URL của admin
        if ($this->isAdminUrl($currentUrl)) {
            return $next($request);
        }

        // Bỏ qua file tĩnh (ảnh, CSS, JS,...)
        if ($this->isStaticAsset($currentUrl)) {
            return $next($request);
        }

        // Bỏ qua bot
        if ($this->isBot($request->userAgent())) {
            return $next($request);
        }

        $today = now()->toDateString();
        $ip = $request->ip();
        $sessionKey = 'visited_' . $today . '_' . sha1($ip . $currentUrl);

        // Kiểm tra nếu session đã tồn tại, bỏ qua để tránh spam
        if (!session()->has($sessionKey)) {
            session([$sessionKey => true]);

            // Kiểm tra xem đã có bản ghi cho IP + URL này trong ngày chưa
            $exists = DB::table('visits')
                ->whereDate('visited_at', $today)
                ->where('ip_address', $ip)
                ->where('url', $currentUrl)
                ->exists();

            if (!$exists) {
                DB::table('visits')->insert([
                    'visited_at' => now(),
                    'ip_address' => $ip,
                    'url' => $currentUrl,
                    'user_agent' => $request->userAgent(),
                ]);
            }
        }

        return $next($request);
    }

    /**
     * Kiểm tra URL có phải admin không.
     */
    protected function isAdminUrl($url)
    {
        return str_starts_with($url, 'admin');
    }

    /**
     * Kiểm tra URL có phải file tĩnh không.
     */
    protected function isStaticAsset($url)
    {
        $staticExtensions = ['js', 'css', 'map', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'woff', 'woff2', 'ttf', 'eot'];
        $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));

        return isset($pathInfo['extension']) && in_array($pathInfo['extension'], $staticExtensions);
    }

    /**
     * Kiểm tra request có phải từ bot không.
     */
    protected function isBot($userAgent)
    {
        if (!$userAgent) {
            return true;
        }

        $bots = ['bot', 'crawl', 'spider', 'slurp', 'bingbot', 'googlebot', 'yahoo', 'yandex', 'duckduckbot'];
        $userAgent = strtolower($userAgent);

        foreach ($bots as $bot) {
            if (str_contains($userAgent, $bot)) {
                return true;
            }
        }

        return false;
    }
}
