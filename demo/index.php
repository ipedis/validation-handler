<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Ipedis\ValidationHandler\ConstraintFactory;
use Ipedis\ValidationHandler\Data\Constraints\FileSize;
use Ipedis\ValidationHandler\Data\Constraints\Mimes\PdfMimeType;
use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;
use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Validator\Helper\ValidationHelper;
use Ipedis\ValidationHandler\Validator\Result\ValidationResult;

$file = __DIR__ . '/../tests/data/265kb.pdf';
$data = new DataWrapper(new SplFileInfo($file));

$validator = ConstraintFactory::build(constraints: [
    new FileSize(100, 'k'),
    new MimeTypes(['application/pdf']),
]);
/** @var ValidationResult $result */
$result = $validator->handle($data);

// should fail.
var_dump($result->isFailed(), $result->getErrorMessage());

$validator = ConstraintFactory::build(constraints: [
    new FileSize(1, 'M'),
    new MimeTypes(['application/pdf']),
]);
/** @var ValidationResult $result */
$result = $validator->handle($data);

// should pass.
var_dump($result->isFailed(), $result->getErrorMessage());

// example of mimetypes helper
$validator = ConstraintFactory::build(constraints: [
    new FileSize(1, 'M'),
    MimeTypes::with(PdfMimeType::class),
]);
/** @var ValidationResult $result */
$result = $validator->handle($data);

// should pass.
var_dump($result->isFailed(), $result->getErrorMessage());

/*
 * Quick helpers to validate file type
 */
var_dump(ValidationHelper::isImage($data));
var_dump(ValidationHelper::isPdf($data));
