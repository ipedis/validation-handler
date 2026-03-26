<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data;

interface DataWrapperInterface
{
    public const SUPPORTED_TYPES = [
        \SplFileInfo::class,
    ];

    public function getData(): \SplFileInfo;

    public function getType(): string;
}
