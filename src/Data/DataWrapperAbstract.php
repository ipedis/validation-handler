<?php

namespace Ipedis\ValidationHandler\Data;

abstract class DataWrapperAbstract implements DataWrapperInterface
{
    public function __construct(protected mixed $data)
    {
        if (!in_array(get_class($this->data), DataWrapperInterface::SUPPORTED_TYPES)) {
            throw new \RuntimeException('Provided data is not yet supported for validation.');
        }
    }
}
