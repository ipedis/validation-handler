<?php

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;
use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;


it ('should fail validation for invalid mimetype', function() {
    $file = new SplFileInfo(getDataDirectory().'malicious_php.pdf');
    $validator = new MimeTypeValidator(
        new MimeTypes(['application/pdf'])
    );

    $result = $validator->handle(new DataWrapper($file));

    $this->assertTrue($result->isFailed());
});

it ('should pass validation for valid mimetype', function() {
    $file = new SplFileInfo(getDataDirectory().'test.txt');
    $validator = new MimeTypeValidator(
        new MimeTypes(['text/plain'])
    );

    $result = $validator->handle(new DataWrapper($file));

    $this->assertFalse($result->isFailed());
});
