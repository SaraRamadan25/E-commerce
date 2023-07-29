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
        Schema::create('migration_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_number');
            $table->string('card_exp_month');
            $table->string('card_exp_year');
            $table->string('card_cvv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('migration_cards');
    }
};
