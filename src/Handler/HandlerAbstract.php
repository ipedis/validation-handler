<?php

namespace Ipedis\ValidationHandler\Handler;

use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Symfony\Component\Validator\Constraint;

abstract class HandlerAbstract implements HandlerInterface
{
    private ?HandlerInterface $nextHandler = null;
    protected array $handlers = [];

    public function __construct(protected readonly DataWrapperInterface $data)
    {
    }

    abstract protected function buildConstraints(): Constraint;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;
        $this->handlers[] = $handler;


        return $handler;
    }

    public function handle()
    {
        return $this->nextHandler?->handle();
    }
}
