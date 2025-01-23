<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Validator\Result;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

readonly class ValidationResult
{
    public function __construct(private ?ConstraintViolationListInterface $violations = null)
    {
    }

    public function isFailed(): bool
    {
        return $this->violations && $this->violations->count() > 0;
    }

    public function getErrorMessage(): ?string
    {
        if ($this->isFailed()) {
            return $this->violations->get(0)->getMessage();
        }

        return null;
    }

    public function getError(): ?ConstraintViolationInterface
    {
        if ($this->isFailed()) {
            return $this->violations->get(0);
        }

        return null;
    }
}
