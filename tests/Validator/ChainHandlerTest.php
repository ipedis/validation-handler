<?php

declare(strict_types=1);

use Ipedis\ValidationHandler\ConstraintFactory;
use Ipedis\ValidationHandler\Data\Constraints\ConstraintInterface;
use Ipedis\ValidationHandler\Data\Constraints\FileSize;
use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;
use Ipedis\ValidationHandler\Data\DataWrapper;

it('should pass all validations for valid data', function () {
    $filePath = getDataDirectory() . '265kb.pdf';
    $data = new DataWrapper(new SplFileInfo($filePath));

    $validator = ConstraintFactory::build([
        new FileSize(1, 'M'),
        new MimeTypes(['application/pdf']),
    ]);

    $result = $validator->handle($data);

    $this->assertFalse($result->isFailed());
});

it('should fail validation if any validator fails', function () {
    $filePath = getDataDirectory() . '265kb.pdf';
    $data = new DataWrapper(new SplFileInfo($filePath));

    $validator = ConstraintFactory::build([
        new FileSize(100, 'k'),
        new MimeTypes(['application/pdf']),
    ]);

    $result = $validator->handle($data);

    $this->assertTrue($result->isFailed());
});

it('should fail validation if any validator fails part 2', function () {
    $filePath = getDataDirectory() . 'malicious_php.pdf';
    $data = new DataWrapper(new SplFileInfo($filePath));

    $validator = ConstraintFactory::build([
        new FileSize(1, 'M'),
        new MimeTypes(['application/pdf']),
    ]);

    $result = $validator->handle($data);

    $this->assertTrue($result->isFailed());
});

it('should throw exception when constraint is not an instance of ConstraintInterface',
    fn () => ConstraintFactory::build([new stdClass()])
)->throws(InvalidArgumentException::class);

it('should throw exception when constraint do not have BindValidator attribute',
    fn () => ConstraintFactory::build([new class implements ConstraintInterface {}])
)->throws(LogicException::class);
