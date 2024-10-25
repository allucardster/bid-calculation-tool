<?php

namespace App\Tests\Service;

use App\Dto\VehicleBidRequestDto;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;
use App\Service\CreateVehicleFromVehicleBidRequestDtoService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CreateVehicleFromVehicleBidRequestDtoServiceTest extends KernelTestCase
{
    private CreateVehicleFromVehicleBidRequestDtoService $service;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->service = $container->get(CreateVehicleFromVehicleBidRequestDtoService::class);
    }

    /**
     * @group integration
     */
    public function testCreateVehicleFromVehicleBidRequestDto(): void
    {
        $request = new VehicleBidRequestDto();
        $request->vehicleType = VehicleTypeEnum::COMMON;
        $request->vehiclePrice = 1000;

        $vehicle = ($this->service)($request);
        $this->assertInstanceOf(Vehicle::class, $vehicle);
        $this->assertEquals($request->vehicleType, $vehicle->type);
        $this->assertEquals($request->vehiclePrice, $vehicle->price);
    }

}