<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
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
            $table->string('name',255);
            $table->string('slug',300)->unique();
            $table->string('sku',255)->unique()->index();
            $table->string('short_description',255)->nullable();
            $table->text('description');
            $table->float('price');
            $table->tinyInteger('in_stock')->default(1);
            $table->tinyInteger('manage_stock')->default(0);
            $table->integer('stock_qty')->default(0)->nullable();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->float('discount')->default(0);
            $table->boolean('has_variant')->default(0)->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_active')->default(1);
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
