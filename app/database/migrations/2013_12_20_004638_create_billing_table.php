<?php

use Illuminate\Database\Migrations\Migration;

class CreateBillingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('billing', function($table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('to');
            $table->integer('cost')->unsigned();
            $table->date('date');
            $table->string('resource_id');
            $table->foreign('user_id')->references('id')->on('users');
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
		Schema::drop('billing');
	}

}