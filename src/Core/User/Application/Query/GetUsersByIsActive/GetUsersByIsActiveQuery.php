<?php

namespace App\Core\User\Application\Query\GetUsersByIsActive;

class GetUsersByIsActiveQuery
{
    public function __construct(
        public readonly bool $isActive,
    )
    {
    }
}
