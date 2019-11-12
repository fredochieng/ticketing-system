<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTicketIdColumnInTicketsActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets_action', function (Blueprint $table) {
            $table->foreign('ticket_id')
            ->references('ticket_id')->on('tickets')
            ->onUpdate('cascade')
            ->onDelete('cascade')->change();
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
            //
        });
    }
}
