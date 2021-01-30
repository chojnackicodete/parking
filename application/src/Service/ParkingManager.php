<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Parking;
use App\Entity\ParkingSlot as ParkingSlotEntity;
use App\Model\VehicleFactory;

class ParkingManager
{

    private ParkingEntityHandler $parkingEntityHandler;
    private VehicleFactory $vehicleFactory;

    public function __construct(ParkingEntityHandler $parkingEntityHandler, VehicleFactory $vehicleFactory)
    {
        $this->parkingEntityHandler = $parkingEntityHandler;
        $this->vehicleFactory = $vehicleFactory;
    }

    public function createParking(string $name, int $rowAmount, int $slotPerRowAmount): Parking
    {
        return Parking::init($name, $rowAmount, $slotPerRowAmount);
    }

    public function parkVehicle(int $id, string $type, string $plateNo): ?ParkingSlotEntity
    {
        $parking = $this->parkingEntityHandler->loadFromDb($id);

        $vehicle = $this->vehicleFactory->createFromData($type, $plateNo);
        $slot = $vehicle->park($parking);

        $this->parkingEntityHandler->persistParking($parking);
        return $slot;
    }

    public function departVehicle(int $id, string $plateNo): bool
    {
        $parking = $this->parkingEntityHandler->loadFromDb($id);

        $status = $parking->departVehicle($plateNo);

        $this->parkingEntityHandler->persistParking($parking);
        return $status;
    }

}

