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
        return $this->violations instanceof ConstraintViolationListInterface && $this->violations->count() > 0;
    }

    public function getErrorMessage(): ?string
    {
        if ($this->violations instanceof ConstraintViolationListInterface && $this->isFailed()) {
            return (string) $this->violations->get(0)->getMessage();
        }

        return null;
    }

    public function getError(): ?ConstraintViolationInterface
    {
        if ($this->violations instanceof ConstraintViolationListInterface && $this->isFailed()) {
            return $this->violations->get(0);
        }

        return null;
    }
}
