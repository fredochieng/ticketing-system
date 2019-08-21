<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsFromTicketsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets_action', function (Blueprint $table) {
          $table->dropColumn('assigned');
          $table->dropColumn('assigned_user_id');
          $table->dropColumn('executed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets_action', function (Blueprint $table) {
            $table->bigInteger('assigned');
            $table->bigInteger('assigned_user_id');
            $table->bigInteger('executed');
        });
    }
}
