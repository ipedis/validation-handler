<?php

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Data\Properties\FileSize;
use Ipedis\ValidationHandler\Data\Properties\MimeTypes;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

it ('should pass all validations for valid data', function() {
    $filePath = getDataDirectory().'265kb.pdf';
    $data = new DataWrapper(new UploadedFile(path: $filePath, originalName: '265kb.pdf', test: true));
    $validator = new FileSizeValidator(
        $data,
        new FileSize('1', 'M')
    );

    $validator->setNext(new MimeTypeValidator(
        $data,
        new MimeTypes(['application/pdf'])
    ));

    $result = $validator->handle();

    $this->assertFalse($result->isFailed());
});

it ('should fail validation if any validator fails', function() {
    $filePath = getDataDirectory().'265kb.pdf';
    $data = new DataWrapper(new UploadedFile(path: $filePath, originalName: '265kb.pdf', test: true));
    $validator = new FileSizeValidator(
        $data,
        new FileSize('100', 'k')
    );

    $validator->setNext(new MimeTypeValidator(
        $data,
        new MimeTypes(['application/pdf'])
    ));

    $result = $validator->handle();

    $this->assertTrue($result->isFailed());
});

it ('should fail validation if any validator fails part 2', function() {
    $filePath = getDataDirectory().'malicious_php.pdf';
    $data = new DataWrapper(new UploadedFile(path: $filePath, originalName: 'malicious_php.pdf', test: true));
    $validator = new FileSizeValidator(
        $data,
        new FileSize('1', 'M')
    );

    $validator->setNext(new MimeTypeValidator(
        $data,
        new MimeTypes(['application/pdf'])
    ));

    $result = $validator->handle();

    $this->assertTrue($result->isFailed());
});
