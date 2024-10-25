<?php

namespace App\Tests\Service\Fee;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;
use App\Service\Fee\CalculateAssociationFeeFromVehicleService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CalculateAssociationFeeFromVehicleServiceTest extends KernelTestCase
{
    private CalculateAssociationFeeFromVehicleService $service;

    public function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->service = $container->get(CalculateAssociationFeeFromVehicleService::class);
    }

    private function assertAssociationFee(Fee $fee, float $expectedValue): void
    {
        $this->assertInstanceOf(Fee::class, $fee);
        $this->assertEquals(FeeTypeEnum::ASSOCIATION, $fee->type);
        $this->assertEquals($expectedValue, $fee->value);
    }

    /**
     * @group integration
     */
    public function testForAnAmountBetween1And500()
    {
        $value = 5;
        $vehicles = [
            new Vehicle(1, VehicleTypeEnum::COMMON),
            new Vehicle(250, VehicleTypeEnum::LUXURY),
            new Vehicle(500, VehicleTypeEnum::COMMON),
        ];

        foreach ($vehicles as $vehicle) {
            $fee = ($this->service)($vehicle);
            $this->assertAssociationFee($fee, $value);
        }
    }

    /**
     * @group integration
     */
    public function testForAnAmountGreaterThan500UpTo1000(): void
    {
        $value = 10;
        $vehicles = [
            new Vehicle(501, VehicleTypeEnum::COMMON),
            new Vehicle(750, VehicleTypeEnum::LUXURY),
            new Vehicle(1000, VehicleTypeEnum::COMMON),
        ];

        foreach ($vehicles as $vehicle) {
            $fee = ($this->service)($vehicle);
            $this->assertAssociationFee($fee, $value);
        }
    }

    /**
     * @group integration
     */
    public function testForAnAmountGreaterThan1000UpTo3000(): void
    {
        $value = 15;
        $vehicles = [
            new Vehicle(1001, VehicleTypeEnum::COMMON),
            new Vehicle(1500, VehicleTypeEnum::LUXURY),
            new Vehicle(3000, VehicleTypeEnum::COMMON),
        ];

        foreach ($vehicles as $vehicle) {
            $fee = ($this->service)($vehicle);
            $this->assertAssociationFee($fee, $value);
        }
    }

    /**
     * @group integration
     */
    public function testForAnAmountOver3000(): void
    {
        $value = 20;
        $vehicles = [
            new Vehicle(3001, VehicleTypeEnum::COMMON),
            new Vehicle(4501, VehicleTypeEnum::LUXURY),
            new Vehicle(6000, VehicleTypeEnum::COMMON),
        ];

        foreach ($vehicles as $vehicle) {
            $fee = ($this->service)($vehicle);
            $this->assertAssociationFee($fee, $value);
        }
    }

    /**
     * @group integration
     */
    public function testForAnAmountNegative(): void
    {
        $value = 0;
        $vehicle = new Vehicle(-1, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertAssociationFee($fee, $value);
    }

    /**
     * @group integration
     */
    public function testForAnAmountEqualToZero(): void
    {
        $value = 0;
        $vehicle = new Vehicle(0, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertAssociationFee($fee, $value);
    }
}