<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data\Constraints\Mimes;

final class ImageMimeType implements BuiltInMimeTypesInterface
{
    private const string APNG = 'image/apng';

    private const string AVIF = 'image/avif';

    private const string GIF = 'image/gif';

    private const string JPEG = 'image/jpeg';

    private const string PNG = 'image/png';

    private const string SVG = 'image/svg+xml';

    private const string WEBP = 'image/webp';

    /** @return string[] */
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
