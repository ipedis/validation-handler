<?php

namespace Ipedis\ValidationHandler\Data\Properties;

class MimeTypes
{
    public function __construct(public readonly array $mimeTypes)
    {
        $this->assertInput();
    }


    /**
     * @return void
     */
    private function assertInput(): void
    {
        $pattern = '/^[-\w.]+\/[-\w.+]+$/';

        foreach ($this->mimeTypes as $mimeType) {
            if (1 !== preg_match($pattern, $mimeType)) {
                throw new \InvalidArgumentException("{$mimeType} is not a valid mime type.");
            }
        }
    }
}
