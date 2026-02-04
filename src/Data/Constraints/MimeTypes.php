<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data\Constraints;

use Ipedis\ValidationHandler\Data\Constraints\Mimes\BuiltInMimeTypesInterface;
use Ipedis\ValidationHandler\Validator\BindValidator;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;

#[BindValidator(validatorClass: MimeTypeValidator::class)]
class MimeTypes implements ConstraintInterface
{
    public function __construct(public readonly array $mimeTypes)
    {
        $this->assertInput();
    }

    /**
     * @param string|BuiltInMimeTypesInterface $mimes FQCN or object
     *
     * @return static
     */
    public static function with(string|BuiltInMimeTypesInterface $mimes): self
    {
        if (is_string($mimes) && !class_exists($mimes)) {
            throw new \InvalidArgumentException("No class found for {$mimes} namespace.");
        }

        return ($mimes instanceof BuiltInMimeTypesInterface) ?
            new self($mimes->getSupportedMimeTypes()) :
            new self((new $mimes())->getSupportedMimeTypes());
    }

    private function assertInput(): void
    {
        $pattern = '/^[-\w.]+\/[-\w.+]+$/';

        foreach ($this->mimeTypes as $mimeType) {
            if (1 !== preg_match($pattern, (string) $mimeType)) {
                throw new \InvalidArgumentException("{$mimeType} is not a valid mime type.");
            }
        }
    }
}
