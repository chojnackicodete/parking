<?php
declare(strict_types=1);

namespace App\Model;

use App\Entity\Vehicle as VehicleEntity;
use App\Entity\ParkingSlot as ParkingSlotEntity;

abstract class Vehicle
{
    const TYPE_CAR = 'car';
    const TYPE_BUS = 'bus';
    const TYPE_MOTORCYCLE = 'motorcycle';

    protected ?int $id = null;
    protected int $size;
    protected string $type;
    protected string $plateNo;

    protected VehicleEntity $vehicleEntity;

    public function __construct(int $size, string $type)
    {
        $this->id = null;
        $this->size = $size;
        $this->type = $type;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function park(Parking $parking): ?ParkingSlotEntity
    {
        return $parking->parkVehicle($this);
    }

    public function leaveParking(): void
    {
        $this->parking->leave($this);
    }

    public function getPlateNo(): string
    {
        return $this->plateNo;
    }

    public function setPlateNo(string $plateNo): void
    {
        $this->plateNo = $plateNo;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return VehicleEntity
     */
    public function getEntity(): VehicleEntity
    {
        return $this->vehicleEntity;
    }

    /**
     * @param VehicleEntity $vehicleEntity
     */
    public function setEntity(VehicleEntity $vehicleEntity): void
    {
        $this->vehicleEntity = $vehicleEntity;
    }

}
