<?php

namespace Ipedis\ValidationHandler\Data;

interface DataWrapperInterface
{
    const SUPPORTED_TYPES = [
        \SplFileInfo::class
    ];

    public function getData();

    public function getType(): string;

}
