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

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('size');
            $table->string('color');
            $table->decimal('original_price');
            $table->decimal('price_after_offer');
/*            $table->bigInteger('rate');*/
            $table->foreignId('category_id')->constrained();
            $table->foreignid('offer_id')->constrained();
            $table->foreignId('checkout_id')->constrained();
            $table->string('image')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
