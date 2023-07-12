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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Professional', 'Business', 'User', 'Carehome'])->nullable();
            $table->enum('professional_type', ['RN', 'CNA', 'HHA', 'Amade Ilave', 'Nutricionista', 'Trabajadora Social'])->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('coupon')->nullable();
            $table->string('coupon_discount')->nullable();
            $table->enum('duration_type', ['day', 'week', 'month'])->nullable();
            $table->bigInteger('duration')->nullable();
            $table->double('price')->nullable();
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
        Schema::dropIfExists('plans');
    }
};
