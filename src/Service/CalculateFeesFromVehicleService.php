<?php

namespace App\Service;

use App\Model\Fee;
use App\Model\Vehicle;
use App\Service\Fee\CalculateAssociationFeeFromVehicleService;
use App\Service\Fee\CalculateBasicFeeFromVehicleService;
use App\Service\Fee\CalculateSpecialFeeFromVehicleService;
use App\Service\Fee\CalculateStorageFeeFromVehicleService;

final class CalculateFeesFromVehicleService
{
    public function __construct(
        private readonly CalculateBasicFeeFromVehicleService $calculateBasicFeeFromVehicleService,
        private readonly CalculateSpecialFeeFromVehicleService $calculateSpecialFeeFromVehicleService,
        private readonly CalculateAssociationFeeFromVehicleService $calculateAssociationFeeFromVehicleService,
        private readonly CalculateStorageFeeFromVehicleService $calculateStorageFeeFromVehicleService,
    ) {

    }

    /**
     * @param Vehicle $vehicle
     * @return Fee[]
     */
    public function __invoke(Vehicle $vehicle): array
    {
        return [
            ($this->calculateBasicFeeFromVehicleService)($vehicle),
            ($this->calculateSpecialFeeFromVehicleService)($vehicle),
            ($this->calculateAssociationFeeFromVehicleService)($vehicle),
            ($this->calculateStorageFeeFromVehicleService)($vehicle),
        ];
    }
}