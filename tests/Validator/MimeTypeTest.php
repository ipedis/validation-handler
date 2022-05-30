<?php

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;
use Ipedis\ValidationHandler\Data\Properties\MimeTypes;
use Symfony\Component\HttpFoundation\File\UploadedFile;


it ('should fail validation for invalid mimetype', function() {
    $filePath = getDataDirectory().'malicious_php.pdf';
    $validator = new MimeTypeValidator(
        new DataWrapper(new UploadedFile(path: $filePath, originalName: 'malicious_php.pdf', test: true)),
        new MimeTypes(['application/pdf'])
    );

    $result = $validator->handle();

    $this->assertTrue($result->isFailed());
});

it ('should pass validation for valid mimetype', function() {
    $filePath = getDataDirectory().'test.txt';
    $validator = new MimeTypeValidator(
        new DataWrapper(new UploadedFile(path: $filePath, originalName: 'test.txt', test: true)),
        new MimeTypes(['text/plain'])
    );

    $result = $validator->handle();

    $this->assertFalse($result->isFailed());
});
