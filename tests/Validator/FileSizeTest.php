<?php

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Data\Properties\FileSize;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

it ('should fail validation for invalid file size', function() {
    $filePath = getDataDirectory().'265kb.pdf';
    $validator = new FileSizeValidator(
        new DataWrapper(new UploadedFile(path: $filePath, originalName: '265kb.pdf', test: true)),
        new FileSize('100', 'k')
    );

    $result = $validator->handle();

    $this->assertTrue($result->isFailed());
});

it ('should pass validation for valid file size', function() {
    $filePath = getDataDirectory().'265kb.pdf';
    $validator = new FileSizeValidator(
        new DataWrapper(new UploadedFile(path: $filePath, originalName: '265kb.pdf', test: true)),
        new FileSize('1', 'M')
    );

    $result = $validator->handle();

    $this->assertFalse($result->isFailed());
});
