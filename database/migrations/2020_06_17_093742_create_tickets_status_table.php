<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketsStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets_status', function(Blueprint $table)
		{
			$table->bigInteger('status_id', true)->unsigned();
			$table->string('status_name', 191);
			$table->string('status_color', 191)->nullable();
			$table->text('ticket_description')->nullable();
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
		Schema::drop('tickets_status');
	}

}
