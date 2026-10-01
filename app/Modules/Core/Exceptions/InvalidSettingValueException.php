<?php

declare(strict_types=1);

namespace App\Modules\Core\Exceptions;

use RuntimeException;

/**
 * Exception thrown when a setting value is invalid for its declared type.
 *
 * This exception is used by SettingService to enforce strict type validation
 * without silent conversion. It is the single, unified contract for all
 * invalid setting value errors within the Core module.
 */
class InvalidSettingValueException extends RuntimeException
{
    public function __construct(
        private readonly string $key,
        private readonly string $expectedType,
        private readonly string $reason,
    ) {
        parent::__construct(
            sprintf(
                'Invalid value for setting "%s" (expected type: %s). Reason: %s',
                $this->key,
                $this->expectedType,
                $this->reason,
            )
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getExpectedType(): string
    {
        return $this->expectedType;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}