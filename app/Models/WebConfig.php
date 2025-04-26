<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebConfig extends Model
{
    protected $fillable = [
        'facebook',
        'youtube',
        'instagram',
        'shopee',
        'tiktok',
        'phone',
        'email',
        'address',
        'zalo',
        'google_maps_iframe',
        'payment_info'
    ];

    protected $casts = [
        'payment_info' => 'array'
    ];

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setZaloAttribute($value)
    {
        if ($value && !str_contains($value, 'zalo.me/')) {
            $numbers = preg_replace('/[^0-9]/', '', $value);
            $value = "https://zalo.me/{$numbers}";
        }
        $this->attributes['zalo'] = $value;
    }
}
