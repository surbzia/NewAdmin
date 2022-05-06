<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('email',255)->nullable(false);
            $table->integer('qty')->default(0);
            $table->text('message')->nullable();
            $table->foreignId('product_id')->constrained();
            $table->tinyInteger('is_new')->default(1);
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
        Schema::dropIfExists('product_quotes');
    }
}
