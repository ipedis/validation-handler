<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Validator;

#[\Attribute(\Attribute::TARGET_CLASS)]
class BindValidator
{
    public function __construct(public readonly string $validatorClass)
    {
    }
}
