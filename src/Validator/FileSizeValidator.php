<?php

namespace Ipedis\ValidationHandler\Validator;

use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Data\Properties\FileSize;
use Ipedis\ValidationHandler\Handler\HandlerAbstract;
use Ipedis\ValidationHandler\Validator\Modal\ValidationResult;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface as BaseValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class FileSizeValidator extends HandlerAbstract
{
    private BaseValidatorInterface $validator;

    public function __construct(protected DataWrapperInterface $data, private readonly FileSize $fileSize)
    {
        $this->validator = Validation::createValidator();
        parent::__construct($data);
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

    protected function buildConstraints(): Constraint
    {
        return new Assert\File([
            'maxSize' => (string)$this->fileSize
        ]);
    }
}
