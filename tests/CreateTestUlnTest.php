<?php 
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use EsfaTools\UlnCreate;
use PHPUnit\Framework\TestCase;


final class CreateTestUlnTest extends TestCase
{
    public function testCreateCorrectNumberOfApprentices(): void
    {
        $epaoOrgId = 'EPA0001';
        $larsCode = 25;
        $sequence = 1;

        $testUln = '';
        try {
            $testUln = UlnCreate::createTestUln ($epaoOrgId, $larsCode, $sequence);}
        catch (Exception $e) {
        }

        $this->assertEquals(
            1000102501,
            $testUln
        );

    }

    public function testExceptionGreaterThanMaxSequence(): void
    {
        $epaoOrgId = 'EPA0001';
        $larsCode = 25;
        $sequence = 11;

        $this->expectException(InvalidArgumentException::class);
        $this->assertFalse(UlnCreate::createTestUln ($epaoOrgId, $larsCode, $sequence));

    }

    public function testExceptionLessThanMaxSequence(): void
    {
        $epaoOrgId = 'EPA0001';
        $larsCode = 25;
        $sequence = 11;

        $this->expectException(InvalidArgumentException::class);
        $this->assertFalse(UlnCreate::createTestUln ($epaoOrgId, $larsCode, $sequence));

    }

    public function testExceptionLarsCodeNotInt(): void
    {
        $epaoOrgId = 'EPA0001';
        $larsCode = 'string';
        $sequence = 11;

        $this->expectException(TypeError::class);
        $this->assertFalse(UlnCreate::createTestUln ($epaoOrgId, $larsCode, $sequence));

    }

}




