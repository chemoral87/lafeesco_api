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
        Schema::create('faith_houses', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("host")->nullable();
            $table->string("host_phone")->nullable();
            $table->string("exhibitor")->nullable();
            $table->string("exhibitor_phone")->nullable();
            $table->string("address")->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
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
        Schema::dropIfExists('faith_houses');
    }
};
