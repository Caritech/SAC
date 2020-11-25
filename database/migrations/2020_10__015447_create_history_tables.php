<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_log', function (Blueprint $table) {
            $table->id();
            $table->string('Date');
            $table->string('User');
            $table->string('Action');
            $table->string('Type');
            $table->string('Summary');
            $table->string('Change');
            $table->string('Location');
        });
        Schema::create('history_log_view', function (Blueprint $table) {
            $table->id();
            $table->string('Date');
            $table->string('User');
            $table->string('Action');
            $table->string('Type');
            $table->string('Summary');
            $table->string('Change');
            $table->string('Location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_log');
        Schema::dropIfExists('history_log_view');
    }
}
