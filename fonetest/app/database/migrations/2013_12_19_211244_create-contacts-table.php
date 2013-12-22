<?php

use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('contacts', function($table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('contact_name', 50);
            $table->string('contact_number', 13);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(array('contact_name', 'contact_number', 'user_id'), 'unique_columns');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('no action');;
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contacts');
	}

}