<?php

function getDataDirectory(): string
{
    return __DIR__.'/data/';
}



/**
 * @param object $obj
 * @param string $name
 * @param array $args
 * @return mixed
 * @throws ReflectionException
 */
function callScopedMethod(object $obj, string $name, array $args): mixed
{
    $class = new ReflectionClass($obj);
    $method = $class->getMethod($name);
    $method->setAccessible(true);
    return $method->invokeArgs($obj, $args);
}
