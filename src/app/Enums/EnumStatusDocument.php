<?php

namespace App\Enums;

enum EnumStatusDocument: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
