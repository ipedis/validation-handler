<?php

namespace Ipedis\ValidationHandler\Validator;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class BindValidator
{
    public function __construct(public readonly string $validatorClass)
    {
    }
}
