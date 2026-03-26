<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Validator;

use Ipedis\ValidationHandler\Data\Constraints\FileSize;
use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Handler\HandlerAbstract;
use Ipedis\ValidationHandler\Validator\Result\ValidationResult;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface as BaseValidatorInterface;
use Symfony\Component\Validator\Constraints\File;

final class FileSizeValidator extends HandlerAbstract
{
    private readonly BaseValidatorInterface $validator;

    public function __construct(private readonly FileSize $fileSize)
    {
        $this->validator = Validation::createValidator();
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
        return new ValidationResult(
            $this->validator->validate(
                $data->getData(),
                $this->buildConstraints()
            )
        );
    }

    protected function buildConstraints(): File
    {
        return new File(maxSize: (string) $this->fileSize);
    }
}
