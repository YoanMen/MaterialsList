<?php

namespace App\Tests;

use App\Service\MaterialService;
use PHPUnit\Framework\TestCase;

class MaterialTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testCalculatingTTCWithTVA10(): void
    {
        $this->assertEquals(136.62, MaterialService::calculateTTC('124.20', '0.10'));
    }

    public function testCalculatingTTCWithTVA20(): void
    {
        $this->assertEquals(305.04, MaterialService::calculateTTC('254.20', '0.20'));
    }

    public function testCalculatingTTCWithTVA5(): void
    {
        $this->assertEquals(14.39, MaterialService::calculateTTC('13.64', '0.055'));
    }

    public function testCalculatingTTCWithTVA2(): void
    {
        $this->assertEquals(55.13, MaterialService::calculateTTC('54', '0.021'));
    }
}
