<?php
declare(strict_types=1);


namespace App\Repository;

use App\Entity\ParkingSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParkingSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParkingSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParkingSlot[]    findAll()
 * @method ParkingSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParkingSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParkingSlot::class);
    }

}