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
        Schema::create('mercancias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->UnsignedBigInteger('precio');
            $table->UnsignedBigInteger('cantidad');
            $table->UnsignedBigInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mercancias');
    }
};
