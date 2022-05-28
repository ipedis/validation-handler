<?php

require_once './vendor/autoload.php';

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Data\Properties\FileSize;
use Ipedis\ValidationHandler\Data\Properties\MimeTypes;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

$file = __DIR__."/../test/data/14mb.pdf";
$f = new SplFileInfo($file);
$data = new DataWrapper(new UploadedFile($f->getRealPath(), '14mb', 'application/pdf'));

$validation = new FileSizeValidator($data, new FileSize('200', 'M'));

$validation->setNext(new MimeTypeValidator($data, new MimeTypes(['text/plain'])));

$result = $validation->handle();

var_dump($result);
