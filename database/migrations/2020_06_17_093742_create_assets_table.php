<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assets', function(Blueprint $table)
		{
			$table->integer('asset_id', true);
			$table->integer('asset_status')->nullable();
			$table->string('staff_name', 191)->nullable();
			$table->string('payroll_no', 191)->nullable();
			$table->string('asset_no', 191)->nullable();
			$table->string('asset_type', 191)->nullable();
			$table->string('model_no', 191)->nullable();
			$table->string('os', 191)->nullable();
			$table->string('serial_no', 191)->nullable();
			$table->string('ram', 191)->nullable();
			$table->string('hdd', 191)->nullable();
			$table->string('system_type', 191)->nullable();
			$table->string('processor', 191)->nullable();
			$table->string('office', 191)->nullable();
			$table->string('antivirus', 191)->nullable();
			$table->string('win_license', 191)->nullable();
			$table->string('country', 191)->nullable();
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
		Schema::drop('assets');
	}

}
