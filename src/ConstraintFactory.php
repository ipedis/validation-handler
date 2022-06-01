<?php

namespace Ipedis\ValidationHandler;

use InvalidArgumentException;
use Ipedis\ValidationHandler\Data\Constraints\ConstraintInterface;
use Ipedis\ValidationHandler\Handler\HandlerAbstract;
use Ipedis\ValidationHandler\Handler\HandlerInterface;
use Ipedis\ValidationHandler\Validator\BindValidator;
use ReflectionClass;
use ReflectionException;

class ConstraintFactory
{
    /**
     * @param ConstraintInterface[] $constraints
     * @throws ReflectionException
     */
    public static function build(array $constraints): HandlerInterface
    {
        $self = new self();
        return $self->bindConstraints($constraints);
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    private function bindConstraints(array $constraints): HandlerInterface
    {
        $validatorHandler = null;
        foreach ($constraints as $constraint) {
            if (!$constraint instanceof ConstraintInterface) {
                throw new InvalidArgumentException('Constraint must be instance of ConstraintInterface');
            }
            $reflection = new ReflectionClass($constraint);
            $attributes = $reflection->getAttributes(BindValidator::class);

            foreach ($attributes as $attribute) {
                $validatorClass = $attribute->newInstance()->validatorClass;
                if ($validatorHandler === null) {
                    /** @var HandlerAbstract $validator */
                    $validatorHandler = new $validatorClass($constraint);
                    continue;
                }
                $validatorHandler->setNext(new $validatorClass($constraint));
            }
        }

        return $validatorHandler;
    }
}
