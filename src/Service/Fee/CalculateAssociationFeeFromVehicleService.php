<?php

namespace App\Service\Fee;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;

final class CalculateAssociationFeeFromVehicleService
{
    public function __invoke(Vehicle $vehicle): Fee
    {
        $value = match (true) {
            $vehicle->price >= 1 && $vehicle->price <= 500 => 5,
            $vehicle->price > 500 && $vehicle->price <= 1000 => 10,
            $vehicle->price > 1000 && $vehicle->price <= 3000 => 15,
            $vehicle->price > 3000 => 20,
            default => 0,
        };

        return new Fee(FeeTypeEnum::ASSOCIATION, $value);
    }
}