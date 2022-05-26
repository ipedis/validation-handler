<?php

namespace Ipedis\ValidationHandler\Data;

class DataWrapper extends DataWrapperAbstract
{
    public function __construct(mixed $data)
    {
        $this->data = $data;
        parent::__construct($data);
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getType(): string
    {
        return get_class($this->getData());
    }
}
