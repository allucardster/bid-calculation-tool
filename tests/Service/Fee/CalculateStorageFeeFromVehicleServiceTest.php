<?php

namespace App\Tests\Service\Fee;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;
use App\Service\Fee\CalculateStorageFeeFromVehicleService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CalculateStorageFeeFromVehicleServiceTest extends KernelTestCase
{
    private CalculateStorageFeeFromVehicleService $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->service = $container->get(CalculateStorageFeeFromVehicleService::class);
    }

    private function assertStorageFee(Fee $fee, float $expectedValue): void
    {
        $this->assertInstanceOf(Fee::class, $fee);
        $this->assertEquals(FeeTypeEnum::STORAGE, $fee->type);
        $this->assertEquals($expectedValue, $fee->value);
    }

    /**
     * @group integration
     */
    public function testFixedStorageFeeForCommonVehicle(): void
    {
        $vehicle = new Vehicle(100, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertStorageFee($fee, 100);
    }

    /**
     * @group integration
     */
    public function testFixedStorageFeeForCommonVehicleWithNegativePrice(): void
    {
        $vehicle = new Vehicle(-1, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertStorageFee($fee, 100);
    }

    /**
     * @group integration
     */
    public function testFixedStorageFeeForCommonVehicleWithZeroPrice(): void
    {
        $vehicle = new Vehicle(0, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertStorageFee($fee, 100);
    }

    /**
     * @group integration
     */
    public function testFixedStorageFeeForLuxuryVehicle(): void
    {
        $vehicle = new Vehicle(0, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertStorageFee($fee, 100);
    }

    /**
     * @group integration
     */
    public function testFixedStorageFeeForLuxuryVehicleWithNegativePrice(): void
    {
        $vehicle = new Vehicle(-1, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertStorageFee($fee, 100);
    }

    /**
     * @group integration
     */
    public function testFixedStorageFeeForLuxuryVehicleWithZeroPrice(): void
    {
        $vehicle = new Vehicle(0, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertStorageFee($fee, 100);
    }
}