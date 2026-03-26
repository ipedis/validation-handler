<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler;

use Ipedis\ValidationHandler\Data\Constraints\ConstraintInterface;
use Ipedis\ValidationHandler\Handler\HandlerInterface;
use Ipedis\ValidationHandler\Validator\BindValidator;

class ConstraintFactory
{
    /**
     * @param ConstraintInterface[] $constraints
     *
     * @throws \ReflectionException
     */
    public static function build(array $constraints): HandlerInterface
    {
        $self = new self();

        return $self->bindConstraints($constraints);
    }

    /**
     * @param ConstraintInterface[] $constraints
     *
     * @throws \ReflectionException
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    private function bindConstraints(array $constraints): HandlerInterface
    {
        $validatorHandler = null;
        foreach ($constraints as $constraint) {
            if (!$constraint instanceof ConstraintInterface) { // @phpstan-ignore instanceof.alwaysTrue
                throw new \InvalidArgumentException('Constraint must be instance of ConstraintInterface');
            }

            $reflection = new \ReflectionClass($constraint);
            $attributes = $reflection->getAttributes(BindValidator::class);

            if ($attributes === []) {
                throw new \LogicException('Constraint must have BindValidator attribute');
            }

            foreach ($attributes as $attribute) {
                $validatorClass = $attribute->newInstance()->validatorClass;
                /** @var HandlerInterface $handler */
                $handler = new $validatorClass($constraint);
                if (!$validatorHandler instanceof HandlerInterface) {
                    $validatorHandler = $handler;
                    continue;
                }

                $validatorHandler->setNext($handler);
            }
        }

        if (!$validatorHandler instanceof HandlerInterface) {
            throw new \InvalidArgumentException('At least one constraint is required');
        }

        return $validatorHandler;
    }
}
