<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audio_id')->constrained()->onDelete('cascade'); // Liên kết với bảng stories
            $table->integer('chuong'); // Số thứ tự chương
            $table->string('audio_url'); // Link file audio nếu có
            $table->time('thoiluong')->nullable()->comment('Thời lượng audio theo định dạng HH:MM:SS');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
