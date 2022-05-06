<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->index();
            $table->string('name',255)->index();
            $table->string('slug',255)->index();
            $table->string('category_alias');
            $table->integer('level')->default(0);
            $table->text('short_description')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('show_in_main_menu')->default(0);
            $table->tinyInteger('show_in_home_sidemenu')->default(0);
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
        Schema::dropIfExists('categories');
    }
}
