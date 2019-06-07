<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_items', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->bigInteger('vender_id')->nullable(false);
            $table->string('componentnumber', 256)->nullable(false);
            $table->string('manufacturer', 256)->nullable(false);
            $table->string('manufacturernumber', 256)->nullable(false);
            $table->string('prices', 1024)->nullable(false);
            $table->string('link', 1024)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_items');
    }
}
