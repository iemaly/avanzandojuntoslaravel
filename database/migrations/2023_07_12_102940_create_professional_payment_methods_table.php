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
        Schema::create('professional_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id')->nullable();
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            $table->enum('type', ['stripe'])->nullable();
            $table->string('public_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('professional_payment_methods');
    }
};
