<?php

namespace App\Tests\Service\Fee;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;
use App\Service\Fee\CalculateSpecialFeeFromVehicleService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CalculateSpecialFeeFromVehicleServiceTest extends KernelTestCase
{
    private CalculateSpecialFeeFromVehicleService $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->service = $container->get(CalculateSpecialFeeFromVehicleService::class);
    }

    private function assertSpecialFee(Fee $fee, float $expectedValue): void
    {
        $this->assertInstanceOf(Fee::class, $fee);
        $this->assertEquals(FeeTypeEnum::SPECIAL, $fee->type);
        $this->assertEquals($expectedValue, $fee->value);
    }

    /**
     * @group integration
     */
    public function testSellerSpecialFeeForCommonVehicle(): void
    {
        $vehicle = new Vehicle(100, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertSpecialFee($fee, 2);
    }

    /**
     * @group integration
     */
    public function testSellerSpecialFeeForCommonVehicleWithNegativePrice(): void
    {
        $vehicle = new Vehicle(-1, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertSpecialFee($fee, 0);
    }

    /**
     * @group integration
     */
    public function testSellerSpecialFeeForCommonVehicleWithZeroPrice(): void
    {
        $vehicle = new Vehicle(0, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertSpecialFee($fee, 0);
    }

    /**
     * @group integration
     */
    public function testSellerSpecialFeeForLuxuryVehicle(): void
    {
        $vehicle = new Vehicle(0, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertSpecialFee($fee, 0);
    }

    /**
     * @group integration
     */
    public function testSellerSpecialFeeForLuxuryVehicleWithNegativePrice(): void
    {
        $vehicle = new Vehicle(-1, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertSpecialFee($fee, 0);
    }

    /**
     * @group integration
     */
    public function testSellerSpecialFeeForLuxuryVehicleWithZeroPrice(): void
    {
        $vehicle = new Vehicle(0, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertSpecialFee($fee, 0);
    }
}