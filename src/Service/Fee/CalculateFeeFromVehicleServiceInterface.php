<?php

namespace App\Service\Fee;

use App\Model\Fee;
use App\Model\Vehicle;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::TAG_NAME)]
interface CalculateFeeFromVehicleServiceInterface
{
    public const TAG_NAME = 'bct.calculate_fee_from_vehicle_service';

    public function __invoke(Vehicle $vehicle): Fee;
}