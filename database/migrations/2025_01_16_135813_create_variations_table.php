<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('color');
            $table->string('size');
            $table->decimal('price', 8, 2);
            $table->integer('stock');
            $table->timestamps();

            $table->unique(['product_id', 'color', 'size']); // Ensures no duplicate variations
        });
    }

    public function down()
    {
        Schema::dropIfExists('variations');
    }
}
