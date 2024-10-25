<?php

namespace App\Service\Fee;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;

final class CalculateBasicFeeFromVehicleService
{
    public function __invoke(Vehicle $vehicle): Fee
    {
        $value = $vehicle->price * 0.10;

        if (VehicleTypeEnum::COMMON === $vehicle->type) {
            $value = match (true) {
                $value < 10 => 10,
                $value > 50 => 50,
                default => $value
            };
        }

        if (VehicleTypeEnum::LUXURY === $vehicle->type) {
            $value = match (true) {
                $value < 25 => 25,
                $value > 200 => 200,
                default => $value
            };
        }

        return new Fee(FeeTypeEnum::BASIC, $value);
    }
}