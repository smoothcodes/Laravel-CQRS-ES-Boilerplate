<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('event_id');
            $table->string('event_type');
            $table->uuid('aggregate_root_id');
            $table->string('aggregate_root_type');
            $table->string('aggregate_root_id_type');
            $table->bigInteger('aggregate_root_version');
            $table->timestampTz('created_at');
            $table->jsonb('payload');

            $table->unique(['aggregate_root_id', 'aggregate_root_version']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
