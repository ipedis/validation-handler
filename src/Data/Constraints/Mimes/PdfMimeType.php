<?php

namespace Ipedis\ValidationHandler\Data\Constraints\Mimes;

final class PdfMimeType implements BuiltInMimeTypesInterface
{
    const PDF = 'application/pdf';

    public function getSupportedMimeTypes(): array
    {
        return [
            self::PDF
        ];
    }
}
