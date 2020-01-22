<?php

namespace CurrencX\Application\CurrencyRate\Adapter\CurrencyLayer;

use SmoothCode\Sample\Application\CurrencyRate\Adapter\CurrencyLayer\GetRateResponse;
use SmoothCode\Sample\Application\CurrencyRate\Adapter\CurrencyLayer\Request;

class GetRateRequest extends Request
{
    public function __construct(
        string $accessKey,
        string $sourceCurrency = 'PLN',
        string $format = '1'
    ) {
        $this->uri              = 'http://www.apilayer.net/api/live';
        $this->method           = 'GET';
        $this->uriSuffixPattern = '';
        $this->uriParams        = [];
        $this->responseClass    = GetRateResponse::class;
        $this->queryParams      = [
            'access_key' => $accessKey,
            'format'     => $format,
            'source'     => $sourceCurrency
        ];

        parent::__construct();
    }
}
