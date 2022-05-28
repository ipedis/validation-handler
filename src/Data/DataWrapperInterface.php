<?php

namespace Ipedis\ValidationHandler\Data;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface DataWrapperInterface
{
    const SUPPORTED_TYPES = [
        UploadedFile::class // may be we will change this to SplFileInfo
    ];

    public function getData();

    public function getType(): string;

}
