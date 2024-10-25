<?php

namespace App\Tests\Service\Fee;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;
use App\Service\Fee\CalculateBasicFeeFromVehicleService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CalculateBasicFeeFromVehicleServiceTest extends KernelTestCase
{
    private CalculateBasicFeeFromVehicleService $service;

    public function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->service = $container->get(CalculateBasicFeeFromVehicleService::class);
    }

    private function assertBasicFee(Fee $fee, float $expectedValue): void
    {
        $this->assertInstanceOf(Fee::class, $fee);
        $this->assertEquals(FeeTypeEnum::BASIC, $fee->type);
        $this->assertEquals($expectedValue, $fee->value);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForCommonVehicleMinimum(): void
    {
        $vehicle = new Vehicle(1, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 10);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForCommonVehicleMaximum(): void
    {
        $vehicle = new Vehicle(501, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 50);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForCommonVehicleBetweenMinimumAndMaximum(): void
    {
        $vehicle = new Vehicle(250, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 25);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForCommonVehicleWithNegativePrice(): void
    {
        $vehicle = new Vehicle(-1, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 10);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForCommonVehicleWithZeroPrice(): void
    {
        $vehicle = new Vehicle(0, VehicleTypeEnum::COMMON);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 10);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForLuxuryVehicleMinimum(): void
    {
        $vehicle = new Vehicle(1, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 25);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForLuxuryVehicleMaximum(): void
    {
        $vehicle = new Vehicle(2001, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 200);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForLuxuryVehicleBetweenMinimumAndMaximum(): void
    {
        $vehicle = new Vehicle(1000, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 100);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForLuxuryVehicleWithNegativePrice(): void
    {
        $vehicle = new Vehicle(-1, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 25);
    }

    /**
     * @group integration
     */
    public function testBasicBuyerFeeForLuxuryVehicleWithZeroPrice(): void
    {
        $vehicle = new Vehicle(0, VehicleTypeEnum::LUXURY);
        $fee = ($this->service)($vehicle);

        $this->assertBasicFee($fee, 25);
    }
}