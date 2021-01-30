<?php
declare(strict_types=1);

namespace App\Model;

use App\Entity\Parking as ParkingEntity;
use App\Entity\ParkingRow as ParkingRowEntity;
use App\Entity\ParkingSlot as ParkingSlotEntity;

use App\Utils\Alpha;

class Parking
{
    private ParkingEntity $parkingEntity;

    public static function init(string $name, int $rowsAmount, int $slotsPerRow): self
    {
        $obj = new static();
        $obj->parkingEntity = new ParkingEntity();
        $obj->parkingEntity->setName($name);
        for($i = 1; $i <= $rowsAmount; $i++) {
            $row = new ParkingRowEntity();
            $row->setAlpha(Alpha::transformToAlpha($i));
            for ($j = 1; $j <= $slotsPerRow; $j++) {
                $slot = new ParkingSlotEntity();
                $slot->setSize(1);
                $slot->setNumber($j);
                $row->addParkingSlot($slot);
            }
            $obj->parkingEntity->addParkingRow($row);
        }
        return $obj;
    }

    public static function fromEntity(ParkingEntity $parking): self
    {
        $obj = new static();
        $obj->parkingEntity = $parking;

        return $obj;
    }

    public function getSpotCount(): int
    {
        return array_sum(array_map(fn ($row) => count($row->getParkingSlots()), $this->parkingEntity->getParkingRows()->toArray()));
    }

    public function getFullSpotCount(): int
    {
        return array_sum(
            array_map(
                fn ($row) => count(
                    array_filter($row->getParkingSlots()->toArray(),
                        fn ($slot) => $slot->getVehicle())
                ),
                $this->parkingEntity->getParkingRows()->toArray()
            )
        );
    }

    private function foundCarSlots(string $plateNo): array
    {
        $slots = [];
        foreach ($this->parkingEntity->getParkingRows() as $parkingRow) {
            foreach ($parkingRow->getParkingSlots() as $slot)
                if ($slot->getVehicle() && $slot->getVehicle()->getPlateNo() === $plateNo) {
                    $slots[] = $slot;
                }
        }
        return $slots;
    }

    public function departVehicle(string $plateNo): bool
    {
        if(count(($slots = $this->foundCarSlots($plateNo)))) {
            foreach ($slots as $slot) {
                $slot->setVehicle(null);
            }
            return true;
        }
        return false;
    }

    public function parkVehicle(Vehicle $vehicle): ?ParkingSlotEntity
    {
        if ($this->foundCarSlots($vehicle->getEntity()->getPlateNo())) {
            return null;
        }
        $slots = $this->getFirstFreeSpots($vehicle->getSize());
        if ($slots) {
            foreach ($slots as $slot) {
                /**
                 * @var ParkingSlotEntity $slot
                 */
                $slot->setVehicle($vehicle->getEntity());
            }
            return $slots[0];
        }
        return null;
    }

    public function getVehicles(): array
    {
        $vehicles = [];
        foreach ($this->parkingEntity->getParkingRows() as $row) {
            foreach ($row->getParkingSlots() as $slot) {
                if (($vehicle = $slot->getVehicle())) {
                    $vehicles[$vehicle->getPlateNo()] = $vehicle;
                }
            }
        }
        return $vehicles;
    }

    private function getFirstFreeSpots(int $size): ?array
    {
        $freeSlots = [];
        foreach ($this->parkingEntity->getParkingRows() as $row) {
            foreach ($row->getParkingSlots() as $slot) {
                if (!$slot->getVehicle()) {
                    $freeSlots[] = $slot;
                }
                if ($size == count($freeSlots)) {
                    return $freeSlots;
                }
            }
            // end of row -> clear and search in next
            $freeSlots = [];
        }
        return $freeSlots;
    }

    public function getEntity(): ParkingEntity
    {
        return $this->parkingEntity;
    }

    public function getName(): string
    {
        return $this->parkingEntity->getName();
    }

    public function setName(string $name): void
    {
        $this->parkingEntity->setName($name);
    }

    public function getRows(): array
    {
        return $this->parkingEntity->getParkingRows();
    }

}
