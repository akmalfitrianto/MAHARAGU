<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_floors')->default(1);
            $table->enum('shape_type', ['rectangle', 'square', 'l_shape', 'u_shape', 'custom'])->default('rectangle');
            $table->text('svg_path')->nullable();
            $table->integer('width')->default(150);
            $table->integer('height')->default(200);
            $table->integer('position_x')->default(0);
            $table->integer('position_y')->default(0);
            $table->string('color')->default('#5eead4');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};