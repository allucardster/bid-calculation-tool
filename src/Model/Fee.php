<?php

namespace App\Model;

class Fee
{
    public function __construct(
        public readonly FeeTypeEnum $type,
        public readonly float $value,
    )
    {

    }
}