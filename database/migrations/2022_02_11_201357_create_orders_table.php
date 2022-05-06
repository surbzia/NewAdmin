<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('billing_first_name',100);
            $table->string('billing_last_name',100);
            $table->string('billing_company',255)->nullable();
            $table->string('billing_email',255);
            $table->string('billing_phone',100);
            $table->string('billing_country',255);
            $table->string('billing_state',255);
            $table->string('billing_city',255);
            $table->string('billing_zipcode',255);
            $table->string('billing_address',255);

            $table->string('shipping_first_name',100);
            $table->string('shipping_last_name',100);
            $table->string('shipping_address',255);
            $table->string('shipping_city',100);
            $table->string('shipping_zip',20);
            $table->string('shipping_phone',100);

            $table->string('shipping_country',255);
            $table->string('shipping_company',255)->nullable();
            $table->string('shipping_state',100);
            $table->string('shipping_notes',555)->nullable()->change();


            $table->integer('order_status')->index()->default(1);//1 = pending, 2 = processing, 3 = holded, 4 = canceled, 5 = complete/delivered
            //processing comes when user has paid through stripe
            $table->string('stripe_charge_id',255)->nullable();
            $table->string('fedex_tracking_id',255)->nullable();
            $table->string('coupon_code',255)->nullable();
            $table->float('discount')->default(0);
            $table->float('discount_amount')->default(0);
            $table->float('tax_percent')->default(0);
            $table->float('tax_amount')->default(0);
            $table->bigInteger('user_id')->index()->default(0);

            $table->float('subtotal');
            $table->float('total');

            $table->timestamps();
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->bigInteger('product_id');
            $table->integer('quantity');
            $table->float('rowtotal');
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_products');
    }
}
