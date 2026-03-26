<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Handler;

use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Validator\Result\ValidationResult;
use Symfony\Component\Validator\Constraint;

abstract class HandlerAbstract implements HandlerInterface
{
    private ?HandlerInterface $nextHandler = null;

    abstract protected function buildConstraints(): Constraint;

    abstract protected function validate(DataWrapperInterface $data): ValidationResult;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        if ($this->nextHandler instanceof HandlerInterface) {
            $this->nextHandler->setNext($handler);
        } else {
            $this->nextHandler = $handler;
        }

        return $this;
    }

    public function handle(DataWrapperInterface $data): ValidationResult
    {
        if ($this->nextHandler instanceof HandlerInterface) {
            return $this->nextHandler->handle($data);
        }

        // if it comes here, it means all validators have passed.
        return new ValidationResult();
    }
}
