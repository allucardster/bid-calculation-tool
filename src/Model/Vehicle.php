<?php

namespace App\Model;

class Vehicle
{
    public function __construct(
        public readonly float $price,
        public readonly VehicleTypeEnum $type,
    ) {

    }
}