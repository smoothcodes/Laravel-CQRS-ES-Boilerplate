<?php declare(strict_types=1);

namespace SmoothCode\Sample\Domain\ExchangeRate\Policy;

use App\Model\Sample\ExchangeRate;
use App\User;
use SmoothCode\Sample\Domain\ExchangeRate\Event\ExchangeRateChanged;
use SmoothCode\Sample\Domain\ExchangeRate\Event\ExchangeRateCreated;
use SmoothCode\Sample\Domain\Tutor\Event\TutorCreated;
use SmoothCode\Sample\Infrastructure\Projection\Projectionist;

class TutorProjection extends Projectionist
{
    public function applyTutorCreated(TutorCreated $tutorCreated)
    {
        $user = User::create(
            [
                'id' => (string) $tutorCreated->getId(),
                'name'     => '',
                'email'    => $tutorCreated->getEmail()->getValue(),
                'password' => $tutorCreated->getPassword()->hashedPassword()
            ]);
    }
}
