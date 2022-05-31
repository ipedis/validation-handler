<?php

require_once './vendor/autoload.php';

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Data\Properties\FileSize;
use Ipedis\ValidationHandler\Data\Properties\MimeTypes;
use Ipedis\ValidationHandler\Validator\Modal\ValidationResult;
use Ipedis\ValidationHandler\ValidatorFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

$file = __DIR__."/../tests/data/265kb.pdf";
/*
 * interesting find, UploadedFile object will not work like this. https://stackoverflow.com/a/67796852
 * But it provides a parameter "test" when set to false it will bypass the is_uploaded_file check.
 */
$data = new DataWrapper(new UploadedFile(
    path: $file,
    originalName: '265kb.pdf',
    test: true
));

$validator = ValidatorFactory::build(validations: [
    new FileSize('100', 'M'),
    new MimeTypes(['application/pdf']),
    new FileSize('300', 'k'),
    new FileSize('200', 'k'),
    new FileSize('100'),
]);
/** @var ValidationResult $result */
$result = $validator->handle($data);

// should fail.
var_dump($result->isFailed(), $result->getErrorMessage());
