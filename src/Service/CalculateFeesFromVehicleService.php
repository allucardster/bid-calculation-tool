<?php

namespace App\Service;

use App\Model\Fee;
use App\Model\Vehicle;
use App\Service\Fee\CalculateFeeFromVehicleServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class CalculateFeesFromVehicleService
{
    /**
     * @param iterable|CalculateFeeFromVehicleServiceInterface[] $handlers
     */
    public function __construct(
        #[TaggedIterator(CalculateFeeFromVehicleServiceInterface::TAG_NAME)] private readonly iterable $handlers
    ) {

    }

    /**
     * @param Vehicle $vehicle
     * @return Fee[]
     */
    public function __invoke(Vehicle $vehicle): array
    {
        $fees = [];
        foreach ($this->handlers as $handler) {
            $fees[] = ($handler)($vehicle);
        }

        return $fees;
    }
}