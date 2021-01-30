<?php
declare(strict_types=1);


namespace App\Repository;

use App\Entity\ParkingRow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParkingRow|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParkingRow|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParkingRow[]    findAll()
 * @method ParkingRow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParkingRowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParkingRow::class);
    }

}