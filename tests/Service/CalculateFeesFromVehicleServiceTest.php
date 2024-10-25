<?php

namespace App\Tests\Service;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;
use App\Service\CalculateFeesFromVehicleService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CalculateFeesFromVehicleServiceTest extends KernelTestCase
{
    private CalculateFeesFromVehicleService $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->service = $container->get(CalculateFeesFromVehicleService::class);
    }

    /**
     * @group integration
     */
    public function testCalculateFeesFromVehicle(): void
    {
        $vehicle = new Vehicle(1000, VehicleTypeEnum::COMMON);
        $fees = ($this->service)($vehicle);
        $this->assertCount(count(FeeTypeEnum::cases()), $fees);
        $this->assertContainsOnly(Fee::class, $fees);

        foreach ($fees as $fee) {
            if (FeeTypeEnum::BASIC === $fee->type) {
                $this->assertEquals(50, $fee->value);
            }

            if (FeeTypeEnum::SPECIAL === $fee->type) {
                $this->assertEquals(20, $fee->value);
            }

            if (FeeTypeEnum::ASSOCIATION === $fee->type) {
                $this->assertEquals(10, $fee->value);
            }

            if (FeeTypeEnum::STORAGE === $fee->type) {
                $this->assertEquals(100, $fee->value);
            }
        }
    }
}