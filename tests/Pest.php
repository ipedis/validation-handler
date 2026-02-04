<?php

declare(strict_types=1);

function getDataDirectory(): string
{
    return __DIR__ . '/data/';
}

/**
 * @throws ReflectionException
 */
function callScopedMethod(object $obj, string $name, array $args): mixed
{
    $class = new ReflectionClass($obj);
    $method = $class->getMethod($name);

    return $method->invokeArgs($obj, $args);
}
