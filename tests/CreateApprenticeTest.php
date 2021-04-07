<?php 
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use EsfaTools\UlnCreate;
use PHPUnit\Framework\TestCase;


final class CreateApprenticeTest extends TestCase
{
    public function testCreateCorrectNumberOfApprentices(): void
    {
        $epaoOrgId = 'EPA0001';
        $larsCode = 25;
        $addNumber = 10;

        $testUlns = UlnCreate::createTestApprentice($epaoOrgId, $larsCode, $addNumber);

        $this->assertEquals(
            10,
            sizeof($testUlns)
        );
    }

    public function testExceptionGreaterThanMaxSequence(): void
    {
        $epaoOrgId = 'EPA0001';
        $larsCode = 25;
        $addNumber = 11;

        $this->expectException(InvalidArgumentException::class);
        UlnCreate::createTestApprentice($epaoOrgId, $larsCode, $addNumber);
    }

    public function testExceptionLessThanMinSequence(): void
    {
        $epaoOrgId = 'EPA0001';
        $larsCode = 25;
        $addNumber = 0;

        $this->expectException(InvalidArgumentException::class);
        UlnCreate::createTestApprentice($epaoOrgId, $larsCode, $addNumber);
    }

    public function testExceptionLarsCodeNotInt(): void
    {
        $epaoOrgId = 'EPA0001';
        $larsCode = 'string';
        $addNumber = 1;

        $this->expectException(TypeError::class);
        UlnCreate::createTestApprentice($epaoOrgId, $larsCode, $addNumber);
    }

}
