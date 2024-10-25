<?php

namespace App\Service;

use App\ApiResource\VehicleBid;
use App\Dto\VehicleBidRequestDto;

final class CalculateVehicleBidFromRequestService
{
    public function __construct(
        private readonly CreateVehicleFromVehicleBidRequestDtoService $createVehicleFromVehicleBidRequestDtoService,
        private readonly CalculateFeesFromVehicleService              $createFeesFromVehicleService,
    ) {

    }

    public function __invoke(VehicleBidRequestDto $request): VehicleBid
    {
        $vehicle = ($this->createVehicleFromVehicleBidRequestDtoService)($request);
        $fees = ($this->createFeesFromVehicleService)($vehicle);

        return new VehicleBid($vehicle, $fees);
    }
}