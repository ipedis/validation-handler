<?php

declare(strict_types=1);

namespace Ipedis\ValidationHandler\Test\Validator;

use Ipedis\ValidationHandler\ConstraintFactory;
use Ipedis\ValidationHandler\Data\Constraints\ConstraintInterface;
use Ipedis\ValidationHandler\Data\Constraints\FileSize;
use Ipedis\ValidationHandler\Data\Constraints\MimeTypes;
use Ipedis\ValidationHandler\Data\DataWrapper;
use PHPUnit\Framework\TestCase;
use SplFileInfo;
use PHPUnit\Framework\Attributes\Test;

final class ChainHandlerTest extends TestCase
{
    /**
     */
    #[Test]
    public function it_should_pass_all_validations_for_valid_data(): void
    {
        $filePath = getDataDirectory() . '265kb.pdf';
        $dataWrapper = new DataWrapper(new SplFileInfo($filePath));

        $validator = ConstraintFactory::build([
            new FileSize(1, 'M'),
            new MimeTypes(['application/pdf']),
        ]);

        $result = $validator->handle($dataWrapper);

        $this->assertFalse($result->isFailed());
    }

    /**
     */
    #[Test]
    public function it_should_fail_validation_if_any_validator_fails(): void
    {
        $filePath = getDataDirectory() . '265kb.pdf';
        $dataWrapper = new DataWrapper(new SplFileInfo($filePath));

        $validator = ConstraintFactory::build([
            new FileSize(100, 'k'),
            new MimeTypes(['application/pdf']),
        ]);

        $result = $validator->handle($dataWrapper);

        $this->assertTrue($result->isFailed());
    }

    /**
     */
    #[Test]
    public function it_should_fail_validation_if_any_validator_fails_part_2(): void
    {
        $filePath = getDataDirectory() . 'malicious_php.pdf';
        $dataWrapper = new DataWrapper(new SplFileInfo($filePath));

        $validator = ConstraintFactory::build([
            new FileSize(1, 'M'),
            new MimeTypes(['application/pdf']),
        ]);

        $result = $validator->handle($dataWrapper);

        $this->assertTrue($result->isFailed());
    }

    /**
     */
    #[Test]
    public function it_should_throw_exception_when_constraint_is_not_an_instance_of_constraint_interface(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        /** @phpstan-ignore argument.type */
        ConstraintFactory::build([new \stdClass()]);
    }

    /**
     */
    #[Test]
    public function it_should_throw_exception_when_constraint_do_not_have_bind_validator_attribute(): void
    {
        $this->expectException(\LogicException::class);

        ConstraintFactory::build([new class () implements ConstraintInterface {}]);
    }

    #[Test]
    public function it_should_throw_exception_when_no_constraints_are_provided(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        ConstraintFactory::build([]);
    }
}
