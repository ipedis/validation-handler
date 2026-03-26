<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data\Constraints;

use Ipedis\ValidationHandler\Validator\BindValidator;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;

#[BindValidator(validatorClass: FileSizeValidator::class)]
class FileSize implements \Stringable, ConstraintInterface
{
    /** @var string[] */
    public const ALLOWED_UNITS = ['k', 'M', 'Ki', 'Mi'];

    /**
     * Build valid file size. for ex. 2M, 100K.
     */
    public function __construct(public readonly int $value, public readonly ?string $unit = null)
    {
        $this->assertValue();
    }

    /**
     * Validates the input.
     */
    private function assertValue(): void
    {
        if ($this->value < 1) {
            throw new \InvalidArgumentException('Value size must be positive integer.');
        }

        if (null !== $this->unit && !in_array($this->unit, self::ALLOWED_UNITS, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid unit provided. It must be one from [%s]', implode(' ', self::ALLOWED_UNITS)));
        }
    }

    public function __toString(): string
    {
        return sprintf('%s%s', $this->value, $this->unit ?: '');
    }
}
