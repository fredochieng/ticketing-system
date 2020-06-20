<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTicketsActionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets_action', function(Blueprint $table)
		{
			$table->foreign('status_id')->references('status_id')->on('tickets_status')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('id', 'tickets_action_ticket_id_foreign')->references('ticket_id')->on('tickets')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tickets_action', function(Blueprint $table)
		{
			$table->dropForeign('tickets_action_status_id_foreign');
			$table->dropForeign('tickets_action_ticket_id_foreign');
		});
	}

}
