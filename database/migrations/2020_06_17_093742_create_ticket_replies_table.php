<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketRepliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_replies', function(Blueprint $table)
		{
			$table->integer('reply_id', true);
			$table->bigInteger('ticket_id')->unsigned()->index('ticket_id');
			$table->string('submitter', 191)->nullable();
			$table->text('message')->nullable();
			$table->timestamps();
			$table->string('reply_type')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ticket_replies');
	}

}
