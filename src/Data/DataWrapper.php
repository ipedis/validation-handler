<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Data;

class DataWrapper extends DataWrapperAbstract
{
    public function __construct($data)
    {
        $this->data = $data;
        parent::__construct($data);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getType(): string
    {
        return $this->getData()::class;
    }
}
