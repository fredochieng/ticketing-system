<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table)
		{
			$table->bigInteger('ticket_id', true)->unsigned();
			$table->string('ticket', 191)->unique();
			$table->bigInteger('status_id')->unsigned();
			$table->bigInteger('priority_id')->unsigned();
			$table->bigInteger('user_id')->unsigned()->nullable();
			$table->string('email', 191);
			$table->string('submitter', 191);
			$table->bigInteger('assigned_user_id')->unsigned()->nullable();
			$table->string('ticket_date', 191)->nullable();
			$table->string('message_id')->nullable();
			$table->string('message_no', 191)->nullable();
			$table->integer('country_id')->nullable();
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
		Schema::drop('tickets');
	}

}
