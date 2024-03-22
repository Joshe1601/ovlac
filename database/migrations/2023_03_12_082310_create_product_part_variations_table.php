<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPartVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_part_variations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_part_id');
            $table->foreign('product_part_id')->references('id')->on('product_parts');

            $table->string('title', 256);
            $table->text('description');
            $table->decimal('price');

            $table->text('model');
            $table->string('color');

            $table->integer('order');

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
        Schema::dropIfExists('product_part_variations');
    }
}
