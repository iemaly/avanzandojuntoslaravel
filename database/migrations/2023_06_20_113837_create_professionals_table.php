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
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carehome_id')->nullable();
            $table->foreign('carehome_id')->references('id')->on('care_homes')->onDelete('cascade');
            $table->enum('type', ['RN', 'CNA', 'HHA', 'Amade Ilave', 'Nutricionista', 'Trabajadora Social'])->nullable();
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('reset_token')->nullable();
            $table->string('auth_token')->nullable();
            $table->longText('access_token')->nullable();
            $table->tinyInteger('email_verified')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_featured')->default(0)->nullable();
            $table->string('featured_payment_id')->nullable();
            $table->dateTime('featured_date')->nullable();
            $table->enum('featured_payment_status', ['pending', 'paid'])->nullable();
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
        Schema::dropIfExists('professionals');
    }
};
