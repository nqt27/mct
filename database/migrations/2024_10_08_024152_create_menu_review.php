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
        Schema::create('menu_review', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->string('name'); // Tên của menu
            $table->unsignedBigInteger('parent_id')->nullable(); // Tham chiếu đến menu cha
            $table->string('slug')->nullable(); // Đường dẫn của menu (nếu có)
            $table->integer('position')->default(0); // Vị trí sắp xếp
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động của menu
            $table->timestamps(); // created_at và updated_at

            // Thiết lập khóa ngoại (self-referencing foreign key)
            $table->foreign('parent_id')->references('id')->on('menu_review')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_review');
    }
};
