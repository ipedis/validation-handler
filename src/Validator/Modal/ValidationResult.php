<?php

namespace Ipedis\ValidationHandler\Validator\Modal;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationResult
{
    public function __construct(private readonly ConstraintViolationListInterface $violations)
    {
    }

    public function isFailed(): bool
    {
        return $this->violations->count() > 0;
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
