<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('desains', function (Blueprint $table) {
            $table->bigInteger("id_desain", 1)->primary();
            $table->bigInteger("id_user")->nullable();
            $table->string('judul');
            $table->string('luas');
            $table->double('harga');
            $table->string("imageUrl");
            
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desains');
    }
};
