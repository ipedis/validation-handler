<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Handler;

class HandlerStack
{
    private array $stack = [];

    public function push(HandlerInterface $handler): void
    {
        $this->stack[] = $handler;
    }

    public function fetch(): ?HandlerInterface
    {
        if (empty($this->stack)) {
            return null;
        }
        $index = array_key_first($this->stack);
        $handler = $this->stack[$index];
        unset($this->stack[$index]);

        return $handler;
    }
}
