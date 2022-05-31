<?php

namespace Ipedis\ValidationHandler\Data;

interface DataWrapperInterface
{
    const SUPPORTED_TYPES = [
        \SplFileInfo::class // may be we will change this to SplFileInfo
    ];

    public function getData();

    public function getType(): string;

}
