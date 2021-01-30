<?php
declare(strict_types=1);

namespace App\Model;

use App\Entity\Vehicle as VehicleEntity;

class VehicleFactory
{
    public function createFromEntity(VehicleEntity $entity): Vehicle
    {
        switch($entity->getType()) {
            case Vehicle::TYPE_MOTORCYCLE:
                $vehicle = new Motorcycle();
                break;
            case Vehicle::TYPE_BUS:
                $vehicle = new Bus();
                break;
            case Vehicle::TYPE_CAR:
            default:
                $vehicle = new Car();
                break;
        }
        $vehicle->setVehicleEntity($entity);
        return $vehicle;
    }

    public function createFromData(string $type, string $plateNo): Vehicle
    {
        switch($type) {
            case Vehicle::TYPE_MOTORCYCLE:
                $vehicle = new Motorcycle();
                break;
            case Vehicle::TYPE_BUS:
                $vehicle = new Bus();
                break;
            case Vehicle::TYPE_CAR:
            default:
                $vehicle = new Car();
                break;
        }
        $entity = new VehicleEntity();
        $entity->setSize($vehicle->getSize());
        $entity->setType($vehicle->getType());
        $entity->setPlateNo($plateNo);

        $vehicle->setEntity($entity);

        return $vehicle;
    }
}
