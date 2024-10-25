<?php

namespace App\Model;

enum FeeTypeEnum: string
{
    case BASIC = 'basic';
    case SPECIAL = 'special';
    case ASSOCIATION = 'association';
    case STORAGE = 'storage';
}
