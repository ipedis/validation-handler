<?php

namespace Ipedis\ValidationHandler\Validator;

use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Data\Properties\FileSize;
use Ipedis\ValidationHandler\Handler\HandlerAbstract;
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

    public function handle()
    {
        $errors = $this->validator->validate($this->data->getData(), $this->buildConstraints());

        if ($errors->count() === 0) {
            return parent::handle();
        }

        return 'File size validator failed.'. $errors->get(0)->getMessageTemplate();
    }

    protected function buildConstraints(): Constraint
    {
        return new Assert\File([
            'maxSize' => (string)$this->fileSize
        ]);
    }
}
