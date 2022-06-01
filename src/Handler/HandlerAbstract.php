<?php

namespace Ipedis\ValidationHandler\Handler;

use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Validator\Result\ValidationResult;
use Symfony\Component\Validator\Constraint;

abstract class HandlerAbstract implements HandlerInterface
{
    protected static ?HandlerStack $handlerStack = null;
    public function __construct()
    {
        if (!self::$handlerStack) {
            self::$handlerStack = new HandlerStack();
        }
    }

    abstract protected function buildConstraints(): Constraint;
    abstract protected function validate(DataWrapperInterface $data): ValidationResult;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        self::$handlerStack->push($handler);

        return $this;
    }

    public function handle(DataWrapperInterface $data): ValidationResult
    {
        $nextHandler = self::$handlerStack->fetch();

        if ($nextHandler) {
            return $nextHandler->handle($data);
        }

        // if it comes here, it means all validators have passed.
        return new ValidationResult();
    }
}
