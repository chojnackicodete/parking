<?php
declare(strict_types=1);

namespace App\Model;

class Motorcycle extends Vehicle
{
    public function __construct()
    {
        parent::__construct(1, Vehicle::TYPE_MOTORCYCLE);
    }

}
