<?php

namespace Ipedis\ValidationHandler\Validator;

use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Data\Properties\MimeTypes;
use Ipedis\ValidationHandler\Handler\HandlerAbstract;
use Ipedis\ValidationHandler\Validator\Modal\ValidationResult;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface as BaseValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MimeTypeValidator extends HandlerAbstract
{
    private BaseValidatorInterface $validator;

    public function __construct(protected DataWrapperInterface $data, private readonly MimeTypes $mimeTypes)
    {
        $this->validator = Validation::createValidator();
        parent::__construct($data);
    }

    protected function buildConstraints(): Constraint
    {
        return new Assert\File([
            'mimeTypes' => $this->mimeTypes->mimeTypes
        ]);
    }

    public function handle(): ValidationResult
    {
        $validationResult = $this->validate();

        if (!$validationResult->isFailed()) {
            return parent::handle();
        }

        return $validationResult;
    }

    protected function validate(): ValidationResult
    {
        return new ValidationResult($this->validator->validate(
            $this->data->getData(),
            $this->buildConstraints())
        );
    }
}
