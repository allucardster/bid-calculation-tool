<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\VehicleBid;
use App\Dto\VehicleBidRequestDto;
use App\Service\CalculateVehicleBidFromRequestService;

final class VehicleBidRequestDtoProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly CalculateVehicleBidFromRequestService $calculateVehicleBidFromRequestService
    ) {

    }

    /**
     * @param VehicleBidRequestDto $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return VehicleBid
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): VehicleBid
    {
        return ($this->calculateVehicleBidFromRequestService)($data);
    }
}