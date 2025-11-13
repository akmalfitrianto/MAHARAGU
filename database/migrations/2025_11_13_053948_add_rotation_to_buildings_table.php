<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            Schema::table('buildings', function (Blueprint $table) {
                $table->integer('rotation')->default(0)->after('height');
            });
        });
    }

    
    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropColumn('rotation');
        });
    }
};
