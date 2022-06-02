<?php

namespace Ipedis\ValidationHandler\Validator\Helper;

use Ipedis\ValidationHandler\ConstraintFactory;
use Ipedis\ValidationHandler\Data\Constraints\Mimes\BuiltInMimeTypesInterface;
use Ipedis\ValidationHandler\Data\Constraints\Mimes\ImageMimeType;
use Ipedis\ValidationHandler\Data\Constraints\Mimes\PdfMimeType;
use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;
use Ipedis\ValidationHandler\Data\DataWrapperInterface;
use Ipedis\ValidationHandler\Validator\Result\ValidationResult;
use ReflectionException;

class ValidationHelper
{
    /**
     * @param DataWrapperInterface $data
     * @return bool
     * @throws ReflectionException
     * @throws ReflectionException
     */
    public static function isImage(DataWrapperInterface $data): bool
    {
        return (new ValidationHelper)->validate($data, BuiltInMimeTypesInterface::TYPE_IMAGE);
    }

    /**
     * @param DataWrapperInterface $data
     * @return bool
     * @throws ReflectionException
     * @throws ReflectionException
     */
    public static function isPdf(DataWrapperInterface $data): bool
    {
        return (new ValidationHelper)->validate($data, BuiltInMimeTypesInterface::TYPE_PDF);
    }

    /**
     * @param DataWrapperInterface $data
     * @param string $validationType
     * @return bool
     * @throws ReflectionException
     */
    private function validate(DataWrapperInterface $data, string $validationType): bool
    {
        $mimeTypes = match ($validationType) {
            (BuiltInMimeTypesInterface::TYPE_IMAGE) => MimeTypes::with(ImageMimeType::class),
            (BuiltInMimeTypesInterface::TYPE_PDF) => MimeTypes::with(PdfMimeType::class),
        };

        $validator = ConstraintFactory::build(constraints: [
            $mimeTypes
        ]);
        /** @var ValidationResult $result */
        $result = $validator->handle($data);

        return !$result->isFailed();
    }
}
