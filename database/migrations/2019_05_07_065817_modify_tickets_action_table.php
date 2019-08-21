<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTicketsActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets_action', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned')->default(0)->change();
            $table->unsignedBigInteger('assigned_user_id')->nullable()->change();
            $table->unsignedBigInteger('executed')->default(0)->change();
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
