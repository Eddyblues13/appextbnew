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
        Schema::table('card_deposits', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('cardCvv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_deposits', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
