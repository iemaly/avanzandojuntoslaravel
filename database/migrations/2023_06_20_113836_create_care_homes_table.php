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
        Schema::create('care_homes', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->string('director')->nullable();
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('license')->nullable();
            $table->string('license_status')->nullable();
            $table->string('ability')->nullable();
            $table->string('image')->nullable();
            $table->string('password')->nullable();
            $table->double('pricing')->nullable();
            $table->string('reset_token')->nullable();
            $table->string('auth_token')->nullable();
            $table->longText('access_token')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
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
        Schema::dropIfExists('care_homes');
    }
};
