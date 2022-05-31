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

    public function __construct(private readonly FileSize $fileSize)
    {
        $this->validator = Validation::createValidator();
        parent::__construct();
    }

    public function handle(DataWrapperInterface $data): ValidationResult
    {
        $validationResult = $this->validate($data);

        if (!$validationResult->isFailed()) {
            return parent::handle($data);
        }

        return $validationResult;
    }

    protected function validate(DataWrapperInterface $data): ValidationResult
    {
        return new ValidationResult($this->validator->validate(
            $data->getData(),
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
