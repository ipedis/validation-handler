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
            if (!$constraint instanceof ConstraintInterface) {
                throw new \InvalidArgumentException('Constraint must be instance of ConstraintInterface');
            }
            $reflection = new \ReflectionClass($constraint);
            $attributes = $reflection->getAttributes(BindValidator::class);

            if (empty($attributes)) {
                throw new \LogicException('Constraint must have BindValidator attribute');
            }

            foreach ($attributes as $attribute) {
                $validatorClass = $attribute->newInstance()->validatorClass;
                if (null === $validatorHandler) {
                    /** @var HandlerInterface $validator */
                    $validatorHandler = new $validatorClass($constraint);
                    continue;
                }
                $validatorHandler->setNext(new $validatorClass($constraint));
            }
        }

        return $validatorHandler;
    }
}
