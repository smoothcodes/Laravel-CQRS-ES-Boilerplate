<?php

namespace CurrencX\Domain\ExchangeRate;

use MyCLabs\Enum\Enum;

/**
 * Class Currency
 * @package CurrencX\Domain\ExchangeRate
 *
 * @method static Currency PLN()
 * @method static Currency EUR()
 * @method static Currency USD()
 */
class Currency extends Enum {
    const PLN = 'PLN';
    const EUR = 'EUR';
    const USD = 'USD';
    //...
}
