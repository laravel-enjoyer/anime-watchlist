<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anime', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false)->index();
            $table->enum('type', ['TV', 'MOVIE', 'OVA', 'ONA', 'SPECIAL', 'UNKNOWN'])->nullable(false);
            $table->integer('episodes')->nullable(false);
            $table->enum('status', ['FINISHED', 'ONGOING', 'UPCOMING', 'UNKNOWN'])->nullable(false);
            $table->enum('season', ['SPRING', 'SUMMER', 'FALL', 'WINTER', 'UNKNOWN'])->nullable(false);
            $table->integer('year')->nullable();
            $table->string('picture')->nullable(false);
            $table->string('thumbnail')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime');
    }
};