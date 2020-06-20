<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssetsMovementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assets_movements', function(Blueprint $table)
		{
			$table->integer('movt_id', true);
			$table->integer('asset_id')->nullable();
			$table->string('asset_no', 191)->nullable();
			$table->string('moved_to', 191)->nullable();
			$table->string('payroll_no', 191)->nullable();
			$table->string('moved_from', 191);
			$table->integer('moved_by');
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
		Schema::drop('assets_movements');
	}

}
