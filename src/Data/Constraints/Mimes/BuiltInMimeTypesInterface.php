<?php

namespace Ipedis\ValidationHandler\Data\Constraints\Mimes;

interface BuiltInMimeTypesInterface
{
    const TYPE_IMAGE = 'image';
    const TYPE_PDF = 'pdf';

    public function getSupportedMimeTypes(): array;
}
