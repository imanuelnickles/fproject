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
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('address');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('property_type')->nullable();
            $table->integer('total_floor')->unsigned();
            $table->integer('total_bedrooms')->unsigned();
            $table->string('building_area')->nullable();
            $table->string('surface_area')->nullable();
            $table->date('purchase_date');
            $table->bigInteger('purchase_price')->unsigned();
            $table->integer('tax')->unsigned();
            $table->integer('valuation')->unsigned();
            $table->bigInteger('rent_price')->unsigned();
            $table->integer('occupied')->usigned()->default(0);
            $table->text('notes')->nullable();
            $table->softDeletes();
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
