<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data;

class DataWrapper extends DataWrapperAbstract
{
    public function getData(): \SplFileInfo
    {
        return $this->data;
    }

    public function getType(): string
    {
        return $this->getData()::class;
    }
}
