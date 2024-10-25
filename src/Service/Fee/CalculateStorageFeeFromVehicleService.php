<?php

namespace App\Service\Fee;

use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;

final class CalculateStorageFeeFromVehicleService
{
    public function __invoke(Vehicle $vehicle): Fee
    {
        return new Fee(FeeTypeEnum::STORAGE, 100);
    }
}