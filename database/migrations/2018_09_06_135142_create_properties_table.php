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
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('post_code');
            $table->string('property_type');  
            $table->integer('total_floor')->unsigned();
            $table->integer('total_bedrooms')->unsigned();
            $table->integer('total_bathrooms')->unsigned();
            $table->integer('building_length')->unsigned();
            $table->integer('building_width')->unsigned();
            $table->integer('area_length')->unsigned();
            $table->integer('area_width')->unsigned();
            $table->date('purchase_date');
            $table->integer('purchase_price')->unsigned();
            $table->integer('tax')->unsigned();
            $table->integer('valuation')->unsigned();
            $table->integer('rent_price')->unsigned();
            $table->integer('occupied')->usigned()->default(0);
            $table->text('notes')->default('');
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
