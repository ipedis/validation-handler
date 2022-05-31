<?php

namespace Ipedis\ValidationHandler;

use Ipedis\ValidationHandler\Handler\HandlerAbstract;
use Ipedis\ValidationHandler\Handler\HandlerInterface;
use Ipedis\ValidationHandler\Validator\BindValidator;
use ReflectionClass;
use ReflectionException;

class ValidatorFactory
{
    /**
     * @throws ReflectionException
     */
    public static function build(array $validations): HandlerInterface
    {
        $self = new self();

        return $self->bindValidators($validations);
    }

    /**
     * @throws ReflectionException
     */
    private function bindValidators(array $validations): HandlerInterface
    {
        $validatorHandler = null;
        foreach ($validations as $validation) {
            $reflection = new ReflectionClass($validation);
            $attributes = $reflection->getAttributes(BindValidator::class);

            foreach ($attributes as $attribute) {
                $validatorClass = $attribute->newInstance()->validatorClass;
                if ($validatorHandler === null) {
                    /** @var HandlerAbstract $validator */
                    $validatorHandler = new $validatorClass($validation);
                    continue;
                }
                $validatorHandler->setNext(new $validatorClass($validation));
            }
        }

        return $validatorHandler;
    }
}
