<?php

use Illuminate\Database\Migrations\Migration;

class CreateContactGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_groups', function($table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('group_name', 50);
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('contacts')->onUpdate('cascade')->onDelete('no action');
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
		Schema::drop('contact_groups');
	}

}