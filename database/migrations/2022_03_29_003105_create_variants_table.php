<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->index();
            $table->bigInteger('attribute_id')->index();
            $table->string('attribute_1');
            $table->string('attribute_2')->nullable();
            $table->string('attribute_3')->nullable();
            $table->string('attribute_1_value');
            $table->string('attribute_2_value')->nullable();
            $table->string('attribute_3_value')->nullable();
            $table->string('sku');
            $table->bigInteger('stock')->nullable();
            $table->bigInteger('sale_price')->nullable();
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('variants');
    }
}
