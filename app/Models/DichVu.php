<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    use HasFactory;
    protected $table = 'dichvu';
    protected $fillable = [
        'tieude',
        'noidung',
        'slug',
        'display',
        'moi',
        'keyword_focus',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'order',
        'image'
    ];
    public function menu_news()
    {
        return $this->belongsTo(MenuDichVu::class);
    }
}
