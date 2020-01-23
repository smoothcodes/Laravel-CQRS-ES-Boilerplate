<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::connection($this->getConnection())->unprepared("CREATE SCHEMA sample");
        Schema::create('sample.exchange_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('aggregate_id')->index('aggregate_id_idx');
            $table->string('source_currency');
            $table->string('target_currency');
            $table->double('rate');
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
        Schema::dropIfExists('sample.exchange_rates');
        DB::connection($this->getConnection())->unprepared("DROP SCHEMA sample");
    }
}
