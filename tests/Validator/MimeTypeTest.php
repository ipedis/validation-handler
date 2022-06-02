<?php

use Ipedis\ValidationHandler\Data\Constraints\Mimes\PdfMimeType;
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

it ('should build mimetype list when used helper', function() {
    $pdf = new PdfMimeType();
    $pdfMime = MimeTypes::with($pdf);

    $this->assertEquals($pdfMime->mimeTypes, $pdf->getSupportedMimeTypes());

    $file = new SplFileInfo(getDataDirectory().'265kb.pdf');
    $validator = new MimeTypeValidator(
        $pdfMime
    );

    $result = $validator->handle(new DataWrapper($file));

    $this->assertFalse($result->isFailed());
});
