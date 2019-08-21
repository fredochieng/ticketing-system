<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIdColumnToTicketsActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets_action', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->after('ticket_id')->nullable();
            $table->foreign('status_id')
                ->references('status_id')->on('tickets_status')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
            $table->unsignedBigInteger('status_id');
        });
    }
}
