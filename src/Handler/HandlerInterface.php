<?php

namespace Ipedis\ValidationHandler\Handler;

interface HandlerInterface
{
    /**
     * @param HandlerInterface $handler
     * @return HandlerInterface
     */
    public function setNext(HandlerInterface $handler): HandlerInterface;

    public function handle();
}
