<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Test\Validator;

use Ipedis\ValidationHandler\Data\Constraints\Mimes\PdfMimeType;
use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;
use Ipedis\ValidationHandler\Data\DataWrapper;
use Ipedis\ValidationHandler\Validator\MimeTypeValidator;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use PHPUnit\Framework\Attributes\Test;

final class MimeTypeTest extends TestCase
{
    /**
     */
    #[Test]
    public function it_should_fail_validation_for_invalid_mimetype(): void
    {
        $file = new SplFileInfo(getDataDirectory() . 'malicious_php.pdf');
        $mimeTypeValidator = new MimeTypeValidator(
            new MimeTypes(['application/pdf'])
        );

        $result = $mimeTypeValidator->handle(new DataWrapper($file));

        $this->assertTrue($result->isFailed());
    }

    /**
     */
    #[Test]
    public function it_should_pass_validation_for_valid_mimetype(): void
    {
        $file = new SplFileInfo(getDataDirectory() . 'test.txt');
        $mimeTypeValidator = new MimeTypeValidator(
            new MimeTypes(['text/plain'])
        );

        $result = $mimeTypeValidator->handle(new DataWrapper($file));

        $this->assertFalse($result->isFailed());
    }

    /**
     */
    #[Test]
    public function it_should_build_mimetype_list_when_used_helper(): void
    {
        $pdfMimeType = new PdfMimeType();
        $pdfMime = MimeTypes::with($pdfMimeType);

        $this->assertEquals($pdfMime->mimeTypes, $pdfMimeType->getSupportedMimeTypes());

        $file = new SplFileInfo(getDataDirectory() . '265kb.pdf');
        $mimeTypeValidator = new MimeTypeValidator(
            $pdfMime
        );

        $result = $mimeTypeValidator->handle(new DataWrapper($file));

        $this->assertFalse($result->isFailed());
    }
}
