<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDailyTicketsSummaryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('daily_tickets_summary', function(Blueprint $table)
		{
			$table->integer('summary_id', true);
			$table->string('date', 191)->unique('uniq_date_index');
			$table->integer('all_tickets')->nullable()->default(0);
			$table->integer('open_tickets')->default(0);
			$table->integer('in_progress')->default(0);
			$table->integer('closed_tickets')->default(0);
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
		Schema::drop('daily_tickets_summary');
	}

}
