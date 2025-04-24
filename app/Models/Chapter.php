<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'audio_id',
        'chapter_number',
        'title',
        'audio_path',
        'duration',
        'views',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function audio()
    {
        return $this->belongsTo(Audio::class);
    }
}
