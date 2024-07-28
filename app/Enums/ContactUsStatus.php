<?php
namespace App\Enums;

use BenSampo\Enum\Enum;

final class ContactUsStatus extends Enum
{
    const INITIAL = 1;
    const SEEN = 2;
    const REPLIED = 3;
}
