<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsFromAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['os_id', 'system_type_id', 'processor_id', 'ram_id', 'hdd_id', 'office_id', 'windows_licence_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->unsignedInteger('os_id');
            $table->unsignedInteger('system_type_id');
            $table->unsignedInteger('processor_id');
            $table->unsignedInteger('ram_id');
            $table->unsignedInteger('hdd_id');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('windows_licence_id');
        });
    }
}