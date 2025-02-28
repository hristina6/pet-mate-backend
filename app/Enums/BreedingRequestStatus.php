<?php

namespace App\Enums;

enum BreedingRequestStatus: string
{
    case PENDING = 'PENDING';

    case APPROVED = 'APPROVED';

    case REJECTED = 'REJECTED';
}
