<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('audio', function (Blueprint $table) {
            $table->boolean('is_series')->default(false);
            $table->integer('total_chapters')->default(0);
            $table->string('audio_path')->nullable();
        });
    }

    public function down()
    {
        Schema::table('audio', function (Blueprint $table) {
            $table->dropColumn(['is_series', 'total_chapters', 'audio_path']);
        });
    }
};
