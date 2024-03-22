<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title', 256);
            $table->text('description');
            $table->decimal('price');

            $table->text('file');

            $table->integer('order');


            $table->decimal('camera_x')->default(0);
            $table->decimal('camera_y')->default(0);
            $table->decimal('camera_z')->default(0);
            $table->decimal('camera_min_zoom')->default(0);
            $table->decimal('camera_max_zoom')->default(0);
            $table->decimal('camera_limit_x')->default(360);
            $table->decimal('camera_limit_y')->default(360);


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
        Schema::dropIfExists('products');
    }
}
