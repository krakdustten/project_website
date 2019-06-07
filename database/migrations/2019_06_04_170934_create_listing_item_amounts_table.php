<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingItemAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_item_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('listing_user_id')->nullable(false);
            $table->bigInteger('listing_item_id')->nullable(false);
            $table->integer('amount')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_item_amounts');
    }
}
