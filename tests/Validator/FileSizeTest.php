<?php

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Data\Properties\FileSize;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;

it ('should fail validation for invalid file size', function() {
    $validator = new FileSizeValidator(
        new FileSize('100', 'k')
    );

    $result = $validator->handle($this->data);

    $this->assertTrue($result->isFailed());
});

it ('should pass validation for valid file size', function() {
    $validator = new FileSizeValidator(
        new FileSize('1', 'M')
    );

    $result = $validator->handle($this->data);

    $this->assertFalse($result->isFailed());
});

beforeEach(function() {
    $filePath = getDataDirectory().'265kb.pdf';
    $this->data = new DataWrapper(new SplFileInfo($filePath));
});
