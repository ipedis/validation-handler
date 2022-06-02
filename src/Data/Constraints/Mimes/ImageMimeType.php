<?php

namespace Ipedis\ValidationHandler\Data\Constraints\Mimes;

final class ImageMimeType implements BuiltInMimeTypesInterface
{
    const APNG = 'image/apng';
    const AVIF = 'image/avif';
    const GIF = 'image/gif';
    const JPEG = 'image/jpeg';
    const PNG = 'image/png';
    const SVG = 'image/svg+xml';
    const WEBP = 'image/webp';

    public function getSupportedMimeTypes(): array
    {
        return [
            self::APNG,
            self::AVIF,
            self::GIF,
            self::JPEG,
            self::PNG,
            self::SVG,
            self::WEBP
        ];
    }
}
