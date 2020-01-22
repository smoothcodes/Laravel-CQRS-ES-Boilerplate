<?php

namespace SmoothCode\Propagation;

use InvalidArgumentException;

class InvalidPayloadException extends InvalidArgumentException {
    public static function requiredFieldsNotSatisfied(string ...$fields): self
    {
        return new static(
            sprintf('Payload missing fields: [%s]', implode(',', $fields))
        );
    }
}
