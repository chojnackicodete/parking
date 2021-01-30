<?php
declare(strict_types=1);

namespace App\Model;

class Bus extends Vehicle
{

    public function __construct()
    {
        parent::__construct(3, Vehicle::TYPE_BUS);
    }
}
