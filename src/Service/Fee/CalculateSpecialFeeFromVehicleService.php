<?php

namespace App\Service\Fee;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;

final class CalculateSpecialFeeFromVehicleService implements CalculateFeeFromVehicleServiceInterface
{
    public function __invoke(Vehicle $vehicle): Fee
    {
        if ($vehicle->price < 0) {
            return new Fee(FeeTypeEnum::SPECIAL, 0);
        }

        $value = match ($vehicle->type) {
            VehicleTypeEnum::COMMON => $vehicle->price * 0.02,
            VehicleTypeEnum::LUXURY => $vehicle->price * 0.04,
            default => 0,
        };

        return new Fee(FeeTypeEnum::SPECIAL, $value);
    }
}