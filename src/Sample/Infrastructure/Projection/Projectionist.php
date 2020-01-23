<?php declare(strict_types=1);

namespace SmoothCode\Sample\Infrastructure\Projection;

use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;

abstract class Projectionist implements Consumer
{

    /**
     * @param Message $message
     * @throws \Exception
     */
    public function handle(Message $message)
    {
        $reflection = new \ReflectionClass($message->event());
        $className = $reflection->getShortName();
        $method = 'apply' . $className;
        if (!method_exists($this, $method)) {
            throw new \Exception(sprintf('Method %s does not exist in %s', $method, $className));
        }

        $this->$method($message->event());
    }

}
