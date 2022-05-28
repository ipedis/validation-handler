<?php

namespace Ipedis\ValidationHandler\Handler;

use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Validator\Modal\ValidationResult;
use Symfony\Component\Validator\Constraint;

abstract class HandlerAbstract implements HandlerInterface
{
    private ?HandlerInterface $nextHandler = null;
    protected array $handlers = [];

    public function __construct(protected DataWrapperInterface $data)
    {
    }

    abstract protected function buildConstraints(): Constraint;
    abstract protected function validate(): ValidationResult;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;
        $this->handlers[] = $handler;


        return $handler;
    }

    public function handle(): ValidationResult
    {
        return $this->nextHandler?->handle();
    }
}
