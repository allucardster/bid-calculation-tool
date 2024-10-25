<?php

namespace App\Dto;

use App\Model\VehicleTypeEnum;

use Symfony\Component\Validator\Constraints as Assert;

final class VehicleBidRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Type('float')]
    #[Assert\GreaterThanOrEqual(0)]
    public ?float $vehiclePrice = null;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [VehicleTypeEnum::class, 'cases'])]
    public ?VehicleTypeEnum $vehicleType = null;
}