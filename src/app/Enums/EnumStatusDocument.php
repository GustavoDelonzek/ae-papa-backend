<?php

namespace App\Enums;

enum EnumStatusDocument: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
