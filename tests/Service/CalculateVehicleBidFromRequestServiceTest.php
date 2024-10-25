<?php

namespace App\Tests\Service;

use App\ApiResource\VehicleBid;
use App\Dto\VehicleBidRequestDto;
use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;
use App\Service\CalculateVehicleBidFromRequestService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CalculateVehicleBidFromRequestServiceTest extends KernelTestCase
{
    private CalculateVehicleBidFromRequestService $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->service = $container->get(CalculateVehicleBidFromRequestService::class);
    }

    /**
     * @group integration
     */
    public function testCalculateVehicleBidFromRequest(): void
    {
        $vehicleBidCase = new VehicleBid(
            new Vehicle(1000000, VehicleTypeEnum::LUXURY),
            [
                new Fee(FeeTypeEnum::BASIC, 200),
                new Fee(FeeTypeEnum::SPECIAL, 40000),
                new Fee(FeeTypeEnum::ASSOCIATION, 20),
                new Fee(FeeTypeEnum::STORAGE, 100),
            ]
        );

        $request = new VehicleBidRequestDto();
        $request->vehiclePrice = $vehicleBidCase->vehicle->price;
        $request->vehicleType = $vehicleBidCase->vehicle->type;

        $result = ($this->service)($request);
        $this->assertInstanceOf(VehicleBid::class, $result);
        $this->assertInstanceOf(Vehicle::class, $result->vehicle);
        $this->assertEquals($vehicleBidCase->vehicle->price, $result->vehicle->price);
        $this->assertEquals($vehicleBidCase->vehicle->type, $result->vehicle->type);
        $this->assertCount(count(FeeTypeEnum::cases()), $result->fees);
        $this->assertContainsOnly(Fee::class, $result->fees);

        foreach ($result->fees as $fee) {
            foreach ($vehicleBidCase->fees as $expectedFee) {
                if (FeeTypeEnum::BASIC === $fee->type && $fee->type === $expectedFee->type) {
                    $this->assertEquals($expectedFee->value, $fee->value);
                }

                if (FeeTypeEnum::SPECIAL === $fee->type && $fee->type === $expectedFee->type) {
                    $this->assertEquals($expectedFee->value, $fee->value);
                }

                if (FeeTypeEnum::ASSOCIATION === $fee->type && $fee->type === $expectedFee->type) {
                    $this->assertEquals($expectedFee->value, $fee->value);
                }

                if (FeeTypeEnum::STORAGE === $fee->type && $fee->type === $expectedFee->type) {
                    $this->assertEquals($expectedFee->value, $fee->value);
                }
            }
        }

        $this->assertEquals($vehicleBidCase->getTotal(), $result->getTotal());
    }
}