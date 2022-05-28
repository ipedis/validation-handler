<?php

require_once './vendor/autoload.php';

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Data\Properties\FileSize;
use Ipedis\ValidationHandler\Data\Properties\MimeTypes;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

$file = __DIR__."/../test/data/test.txt";
/*
 * interesting find, UploadedFile object will not work like this. https://stackoverflow.com/a/67796852
 * But it provides a parameter "test" when set to false it will bypass the is_uploaded_file check.
 */
$data = new DataWrapper(new UploadedFile(
    path: $file,
    originalName: '14mb',
    test: true
));

$validation = new FileSizeValidator($data, new FileSize('2', 'M'));

$validation->setNext(new MimeTypeValidator($data, new MimeTypes(['application/pdf'])));

$result = $validation->handle();

// should fail.
var_dump($result->isFailed());
