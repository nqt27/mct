<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'images',
        'audio_path',
        'is_series',
        'total_chapters'
    ];

    protected $casts = [
        'display' => 'boolean',
        'nghenhieu' => 'boolean',
        'moi' => 'boolean',
        'images' => 'array',
        'is_series' => 'boolean'
    ];

    public function setFilenamesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function theloai()
    {
        return $this->belongsTo(TheLoai::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('chapter_number');
    }

    public function isSeries()
    {
        return $this->is_series;
    }

    public function getLatestChapter()
    {
        return $this->chapters()->latest()->first();
    }
}
