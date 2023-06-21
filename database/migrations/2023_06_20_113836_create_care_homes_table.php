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
            $table->string('establishment')->nullable();
            $table->string('director')->nullable();
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('license')->nullable();
            $table->string('license_status')->nullable();
            $table->string('ability')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
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
