<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data\Constraints;

use Ipedis\ValidationHandler\Data\Constraints\Mimes\BuiltInMimeTypesInterface;
use Ipedis\ValidationHandler\Validator\BindValidator;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;

#[BindValidator(validatorClass: MimeTypeValidator::class)]
class MimeTypes implements ConstraintInterface
{
    /** @param string[] $mimeTypes */
    public function __construct(public readonly array $mimeTypes)
    {
        $this->assertInput();
    }

    /**
     * @param class-string<BuiltInMimeTypesInterface>|BuiltInMimeTypesInterface $mimes FQCN or object
     */
    public static function with(string|BuiltInMimeTypesInterface $mimes): self
    {
        if (is_string($mimes) && !class_exists($mimes)) {
            throw new \InvalidArgumentException(sprintf('No class found for %s namespace.', $mimes));
        }

        if ($mimes instanceof BuiltInMimeTypesInterface) {
            return new self($mimes->getSupportedMimeTypes());
        }

        /** @var BuiltInMimeTypesInterface $instance */
        $instance = new $mimes();

        return new self($instance->getSupportedMimeTypes());
    }

    private function assertInput(): void
    {
        $pattern = '/^[-\w.]+\/[-\w.+]+$/';

        foreach ($this->mimeTypes as $mimeType) {
            if (1 !== preg_match($pattern, (string) $mimeType)) {
                throw new \InvalidArgumentException($mimeType . ' is not a valid mime type.');
            }
        }
    }
}
