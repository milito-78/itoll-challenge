<?php

namespace App\Domains\Enums;

enum OrderChangeStatusByTypeEnum : int
{
    case Company = 1;

    case Transporter = 2;

    case System = 3;

    case Admin = 4;
}
