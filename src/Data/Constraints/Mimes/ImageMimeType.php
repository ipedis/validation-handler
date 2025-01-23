<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data\Constraints\Mimes;

final class ImageMimeType implements BuiltInMimeTypesInterface
{
    private const APNG = 'image/apng';
    private const AVIF = 'image/avif';
    private const GIF = 'image/gif';
    private const JPEG = 'image/jpeg';
    private const PNG = 'image/png';
    private const SVG = 'image/svg+xml';
    private const WEBP = 'image/webp';

    public function getSupportedMimeTypes(): array
    {
        return [
            self::APNG,
            self::AVIF,
            self::GIF,
            self::JPEG,
            self::PNG,
            self::SVG,
            self::WEBP,
        ];
    }
}
