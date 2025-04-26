<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'content',
        'analytics_code',
        'analytics_script',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get active analytics code
    public function getActiveAnalyticsCodeAttribute()
    {
        return !empty($this->analytics_code) ? $this->analytics_code : null;
    }

    // Get formatted analytics script
    public function getFormattedAnalyticsScriptAttribute()
    {
        if (empty($this->analytics_script)) {
            return null;
        }
        return $this->formatScript($this->analytics_script);
    }

    // Format script for display
    private function formatScript($script)
    {
        $script = preg_replace('/>\s+</', ">\n<", $script);
        $script = preg_replace('/\s+$/', "", $script);
        return trim($script);
    }

    public function getAnalyticsScript()
    {
        if (empty($this->analytics_code)) {
            return null;
        }

        return <<<HTML
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={$this->analytics_code}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{$this->analytics_code}');
        </script>
        HTML;
    }
}
