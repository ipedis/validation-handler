<?php

require_once './vendor/autoload.php';

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

$data = new DataWrapper(new UploadedFile("", 'test'));

$validation = new FileSizeValidator($data);

$validation->setNext(new MimeTypeValidator($data));

$validation->validate();
