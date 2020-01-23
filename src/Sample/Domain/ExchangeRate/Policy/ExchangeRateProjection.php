<?php declare(strict_types=1);

namespace SmoothCode\Sample\Domain\ExchangeRate\Policy;

use App\Model\Sample\ExchangeRate;
use SmoothCode\Sample\Domain\ExchangeRate\Event\ExchangeRateCreated;
use SmoothCode\Sample\Infrastructure\Projection\Projectionist;

class ExchangeRateProjection extends Projectionist
{
    public function applyExchangeRateCreated(ExchangeRateCreated $exchangeRateCreated)
    {
        ExchangeRate::create(
            [
                'aggregate_id' => (string) $exchangeRateCreated->getId(),
                'source_currency' => (string)$exchangeRateCreated->getSourceCurrency(),
                'target_currency' => (string)$exchangeRateCreated->getTargetCurrency(),
                'rate'            => $exchangeRateCreated->getRate()
            ]);
    }

    public function applyExchangeRateChanged(ExchangeRateChanged $exchangeRateChanged)
    {

    }
}
