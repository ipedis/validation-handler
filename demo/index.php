<?php

require_once './vendor/autoload.php';

use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Data\Constraints\FileSize;
use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;
use Ipedis\ValidationHandler\Validator\Modal\ValidationResult;
use Ipedis\ValidationHandler\ValidatorFactory;

$file = __DIR__."/../tests/data/265kb.pdf";
$data = new DataWrapper(new SplFileInfo($file));

$validator = ValidatorFactory::build(validations: [
    new FileSize('100', 'k'),
    new MimeTypes(['application/pdf'])
]);
/** @var ValidationResult $result */
$result = $validator->handle($data);

// should fail.
var_dump($result->isFailed(), $result->getErrorMessage());

$validator = ValidatorFactory::build(validations: [
    new FileSize('1', 'M'),
    new MimeTypes(['application/pdf'])
]);
/** @var ValidationResult $result */
$result = $validator->handle($data);

// should pass.
var_dump($result->isFailed(), $result->getErrorMessage());
