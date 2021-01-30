<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Parking;
use App\Repository\ParkingRepository;
use App\Repository\ParkingRowRepository;
use App\Repository\ParkingSlotRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParkingEntityHandler
{
    private EntityManagerInterface $em;

    private ParkingRepository $parkingRepository;
    private ParkingRowRepository $parkingRowRepository;
    private ParkingSlotRepository $parkingSlotRepository;
    private VehicleRepository $vehicleRepository;

    public function __construct(EntityManagerInterface $em,
                                ParkingRepository $parkingRepository,
                                ParkingRowRepository $parkingRowRepository,
                                ParkingSlotRepository $parkingSlotRepository,
                                VehicleRepository $vehicleRepository
    )
    {
        $this->em = $em;
        $this->parkingRepository = $parkingRepository;
        $this->parkingRowRepository = $parkingRowRepository;
        $this->parkingSlotRepository = $parkingSlotRepository;
        $this->vehicleRepository = $vehicleRepository;
    }

    public function persistParking(Parking $parking): int
    {
        $parkingEntity = $parking->getEntity();
        $this->persistAndFlush($parkingEntity);
        return $parkingEntity->getId();
    }

    private function persistAndFlush($obj){
        $this->em->persist($obj);
        $this->em->flush();
    }

    public function loadFromDb(int $id): Parking
    {
        $parkingEntity = $this->parkingRepository->findOneBy(['id' => $id]);

        return Parking::fromEntity($parkingEntity);
    }
}
