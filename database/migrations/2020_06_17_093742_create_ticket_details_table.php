<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_details', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('issue_id')->unsigned()->nullable();
			$table->bigInteger('sub_id')->unsigned()->nullable();
			$table->string('subject', 191)->nullable();
			$table->text('description')->nullable();
			$table->text('attached_file')->nullable();
			$table->bigInteger('issue_type_id')->unsigned()->nullable();
			$table->bigInteger('issue_subtype_id')->unsigned()->nullable();
			$table->string('service_affecting', 191)->nullable();
			$table->timestamps();
			$table->dateTime('assigned_at')->nullable();
			$table->dateTime('closed_at')->nullable();
			$table->string('closed_date', 191)->nullable();
			$table->integer('esc_level_id')->nullable();
			$table->text('esc_reason')->nullable();
			$table->string('escalated_at', 191)->nullable();
			$table->string('escalated_by', 191)->nullable();
			$table->integer('closed_by')->nullable();
			$table->text('reason')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ticket_details');
	}

}
