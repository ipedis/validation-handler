<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Test\Validator;

use Ipedis\ValidationHandler\Data\Constraints\FileSize;
use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Validator\FileSizeValidator;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use PHPUnit\Framework\Attributes\Test;

final class FileSizeTest extends TestCase
{
    private DataWrapper $data;

    protected function setUp(): void
    {
        $filePath = getDataDirectory() . '265kb.pdf';
        $this->data = new DataWrapper(new SplFileInfo($filePath));
    }

    /**
     */
    #[Test]
    public function it_should_fail_validation_for_invalid_file_size(): void
    {
        $fileSizeValidator = new FileSizeValidator(
            new FileSize(100, 'k')
        );

        $result = $fileSizeValidator->handle($this->data);

        $this->assertTrue($result->isFailed());
    }

    /**
     */
    #[Test]
    public function it_should_pass_validation_for_valid_file_size(): void
    {
        $fileSizeValidator = new FileSizeValidator(
            new FileSize(1, 'M')
        );

        $result = $fileSizeValidator->handle($this->data);

        $this->assertFalse($result->isFailed());
    }
}
