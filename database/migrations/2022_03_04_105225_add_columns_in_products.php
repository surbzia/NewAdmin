<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('in_stock')->default(1);
            $table->tinyInteger('manage_stock')->default(0);
            $table->integer('stock_qty')->default(0)->nullable();
            //in stock will work only when manage stock is 0 otherwise manage stock will get the priority
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('crawl_url');
            $table->dropColumn('crawl_site');
            $table->dropColumn('in_stock');
            $table->dropColumn('manage_stock');
            $table->dropColumn('stock_qty');
        });
    }
}
