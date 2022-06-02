<?php

namespace Ipedis\ValidationHandler\Data\Constraints;

use Ipedis\ValidationHandler\Data\Constraints\Mimes\BuiltInMimeTypesInterface;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;
use Ipedis\ValidationHandler\Validator\BindValidator;

#[BindValidator(validatorClass: MimeTypeValidator::class)]
class MimeTypes implements ConstraintInterface
{
    public function __construct(public readonly array $mimeTypes)
    {
        $this->assertInput();
    }

    /**
     * @param string|BuiltInMimeTypesInterface $mimes FQCN or object
     * @return static
     */
    public static function with(string|BuiltInMimeTypesInterface $mimes): self
    {
        if (is_string($mimes) && !class_exists($mimes)) {
            throw new \InvalidArgumentException("No class found for {$mimes} namespace.");
        }

        return ($mimes instanceof BuiltInMimeTypesInterface) ?
            new self($mimes->getSupportedMimeTypes()) :
            new self((new $mimes)->getSupportedMimeTypes());
    }

    /**
     * @return void
     */
    private function assertInput(): void
    {
        $pattern = '/^[-\w.]+\/[-\w.+]+$/';

        foreach ($this->mimeTypes as $mimeType) {
            if (1 !== preg_match($pattern, $mimeType)) {
                throw new \InvalidArgumentException("{$mimeType} is not a valid mime type.");
            }
        }
    }
}
