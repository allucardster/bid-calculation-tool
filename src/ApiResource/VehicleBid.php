<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Dto\VehicleBidRequestDto;
use App\Model\Fee;
use App\Model\Vehicle;
use App\State\VehicleBidRequestDtoProcessor;

#[ApiResource(operations: [
    new Post(input: VehicleBidRequestDto::class, processor: VehicleBidRequestDtoProcessor::class)
])]
final class VehicleBid
{
    public function __construct(
        public readonly Vehicle $vehicle,
        /** @var Fee[] */
        public readonly array $fees = []
    ) {

    }

    public function getTotal(): float
    {
        $total = $this->vehicle->price;
        foreach ($this->fees as $fee) {
            $total += $fee->value;
        }

        return $total;
    }
}