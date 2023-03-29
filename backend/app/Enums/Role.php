<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Role extends Enum
{
    const ADMIN = 1;
    const USER = 2;
    const TEACHER = 3;
    const STUDENT = 4;
}
