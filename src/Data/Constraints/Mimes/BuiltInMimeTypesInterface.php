<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data\Constraints\Mimes;

interface BuiltInMimeTypesInterface
{
    public const TYPE_IMAGE = 'image';

    public const TYPE_PDF = 'pdf';

    /** @return string[] */
    public function getSupportedMimeTypes(): array;
}
