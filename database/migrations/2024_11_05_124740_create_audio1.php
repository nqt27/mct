<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('ten');
            $table->text('tomtat');
            $table->text('tacgia');
            $table->string('image');
            $table->integer('luot_nghe')->default(0);
            $table->boolean('display')->default(true);
            $table->boolean('moi')->default(true);
            $table->boolean('nghenhieu')->default(true);
            $table->unsignedBigInteger('theloai_id'); // Thêm cột khóa ngoại
            $table->string('keyword_focus')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->integer('order')->default(0); // Thêm trường thứ tự
            $table->text('seo_description')->nullable();
            // $table->json('images')->nullable(); // thêm cột JSON
            $table->foreign('theloai_id')->references('id')->on('theloai')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio');
    }
};
