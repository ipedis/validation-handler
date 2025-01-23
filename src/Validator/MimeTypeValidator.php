<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Validator;

use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;
use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Handler\HandlerAbstract;
use Ipedis\ValidationHandler\Validator\Result\ValidationResult;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface as BaseValidatorInterface;

final class MimeTypeValidator extends HandlerAbstract
{
    private BaseValidatorInterface $validator;

    public function __construct(private readonly MimeTypes $mimeTypes)
    {
        $this->validator = Validation::createValidator();
        parent::__construct();
    }

    protected function buildConstraints(): Constraint
    {
        return new Assert\File([
            'mimeTypes' => $this->mimeTypes->mimeTypes,
        ]);
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
}
