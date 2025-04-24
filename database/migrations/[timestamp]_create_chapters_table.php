<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audio_id')->constrained('audio')->onDelete('cascade');
            $table->integer('chapter_number');
            $table->string('title');
            $table->string('audio_path');
            $table->string('duration')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->unique(['audio_id', 'chapter_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chapters');
    }
};
