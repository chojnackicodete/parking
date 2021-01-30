<?php
declare(strict_types=1);

namespace App\Model\DTO;
use App\Model\Parking;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class ParkingStatusDTO
{
    /**
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     */
    private int $parkingId;

    /**
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     */
    private int $freeSpots;

    /**
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     */
    private int $usedSpot;

    /**
     * @Serializer\Expose()
     * @Serializer\Type("array")
     */
    private array $vehicles = [];


    public function __construct(Parking $parking)
    {
        $this->parkingId = $parking->getEntity()->getId();
        $this->usedSpot = $parking->getFullSpotCount();
        $this->freeSpots = $parking->getSpotCount() - $parking->getFullSpotCount();

        foreach ($parking->getVehicles() as $vehicle) {
            $this->vehicles[] = new VehicleDTO($vehicle);
        }
    }

    /**
     * @return int|null
     */
    public function getParkingId(): ?int
    {
        return $this->parkingId;
    }

    /**
     * @param int|null $parkingId
     */
    public function setParkingId(?int $parkingId): void
    {
        $this->parkingId = $parkingId;
    }

    /**
     * @return int
     */
    public function getFreeSpots(): int
    {
        return $this->freeSpots;
    }

    /**
     * @param int $freeSpots
     */
    public function setFreeSpots(int $freeSpots): void
    {
        $this->freeSpots = $freeSpots;
    }

    /**
     * @return int
     */
    public function getUsedSpot(): int
    {
        return $this->usedSpot;
    }

    /**
     * @param int $usedSpot
     */
    public function setUsedSpot(int $usedSpot): void
    {
        $this->usedSpot = $usedSpot;
    }



}