<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';
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
        'image'
    ];
    public function menu_news()
    {
        return $this->belongsTo(MenuBlog::class);
    }
}
