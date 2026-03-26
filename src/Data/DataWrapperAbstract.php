<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data;

abstract class DataWrapperAbstract implements DataWrapperInterface
{
    public function __construct(protected \SplFileInfo $data)
    {
        if (!in_array($this->data::class, DataWrapperInterface::SUPPORTED_TYPES, true)) {
            throw new \RuntimeException('Provided data is not yet supported for validation.');
        }
    }
}
