<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('web_configs', function (Blueprint $table) {
            $table->id();
            // Social Media Links
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('shopee')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('zalo')->nullable();

            // Google Maps
            $table->text('google_maps_link')->nullable();
            $table->text('google_maps_iframe')->nullable();

            // Payment Info
            $table->json('payment_info')->nullable();


          

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('web_configs');
    }
};
