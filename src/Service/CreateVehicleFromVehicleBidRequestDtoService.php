<?php

namespace App\Service;

use App\Dto\VehicleBidRequestDto;
use App\Model\Vehicle;

final class CreateVehicleFromVehicleBidRequestDtoService
{
    public function __invoke(VehicleBidRequestDto $request): Vehicle
    {
        return new Vehicle($request->vehiclePrice, $request->vehicleType);
    }
}