<?php

namespace App\Domains\Enums;

enum OrderStatusEnum : int
{
    case Created = 1;

    case Accepted = 2;

    case Moving = 3;

    case Completed = 4;

    case Canceled = 5;
}
