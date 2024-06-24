<?php

namespace App\Domain\Shared;

use Symfony\Component\Uid\Uuid;

class IdGenerator
{
    /**
     * @return Uuid
     */
    public function generate(): Uuid
    {
        return Uuid::v6();
    }
}