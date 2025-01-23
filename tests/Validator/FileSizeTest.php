<?php

declare(strict_types=1);

use Ipedis\ValidationHandler\Data\Constraints\FileSize;
use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;

it('should fail validation for invalid file size', function () {
    $validator = new FileSizeValidator(
        new FileSize(100, 'k')
    );

    // @phpstan-ignore-next-line
    $result = $validator->handle($this->data);

    $this->assertTrue($result->isFailed());
});

it('should pass validation for valid file size', function () {
    $validator = new FileSizeValidator(
        new FileSize(1, 'M')
    );

    // @phpstan-ignore-next-line
    $result = $validator->handle($this->data);

    $this->assertFalse($result->isFailed());
});

beforeEach(function () {
    $filePath = getDataDirectory() . '265kb.pdf';
    // @phpstan-ignore-next-line
    $this->data = new DataWrapper(new SplFileInfo($filePath));
});
