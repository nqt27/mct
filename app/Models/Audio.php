<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\Output\Theme;

class Audio extends Model
{
    use HasFactory;
    protected $table = 'audio';
    protected $fillable = [
        'slug',
        'ten',
        'tomtat',
        'image',
        'tacgia',
        'luot_nghe',
        'theloai_id',
        'display',
        'moi',
        'nghenhieu',
        'keyword_focus',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'images'
    ];
    public function setFilenamesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }
    public function theloai()
    {
        return $this->belongsTo(TheLoai::class);
    }
    public function chuong()
    {
        return $this->hasMany(Chapter::class);
    }
}
