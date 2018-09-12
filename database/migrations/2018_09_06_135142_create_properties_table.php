<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('property_id');
            $table->string('name');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('country');
            $table->string('city');
            $table->string('post_code');
            $table->boolean('multiunit');
            $table->integer('total_bedrooms');
            $table->integer('total_bathrooms');
            $table->integer('total_area');
            $table->date('purchase_date');
            $table->integer('purchase_price');
            $table->integer('purchase_tax');
            $table->integer('current_valuation');
            $table->text('notes');

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
        Schema::dropIfExists('properties');
    }
}
