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
        Schema::create('care_home_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carehome_id')->nullable();
            $table->foreign('carehome_id')->references('id')->on('care_homes')->onDelete('cascade');
            $table->enum('type', ['blueprint', 'hospital', 'personal', 'resume'])->nullable();
            $table->string('document')->nullable();
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
        Schema::dropIfExists('care_home_media');
    }
};
