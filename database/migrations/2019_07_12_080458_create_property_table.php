<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('cost_of_building')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('market_value')->nullable();
            $table->integer('forced_sale_value')->nullable();
            $table->integer('return_on_investment')->nullable();
            $table->integer('property_type_id');
            $table->integer('publisher_id');
            $table->text('sponsor')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
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
