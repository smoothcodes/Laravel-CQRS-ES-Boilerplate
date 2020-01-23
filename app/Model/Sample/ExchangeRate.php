<?php

namespace App\Model\Sample;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $table = 'sample.exchange_rates';

    protected $fillable = [
        'aggregate_id',
        'source_currency',
        'target_currency',
        'rate'
    ];
}
