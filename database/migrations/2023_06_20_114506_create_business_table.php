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
        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('reset_token')->nullable();
            $table->string('auth_token')->nullable();
            $table->longText('access_token')->nullable();
            $table->tinyInteger('email_verified')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_viewed')->default(0);
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
        Schema::dropIfExists('business');
    }
};
