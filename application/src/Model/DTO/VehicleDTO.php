<?php
declare(strict_types=1);

namespace App\Model\DTO;
use App\Entity\Vehicle;
use JMS\Serializer\Annotation as Serializer;


class VehicleDTO
{
    /**
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    private string $type;

    /**
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    private string $plateNo;

    /**
     */
    public function __construct(Vehicle $vehicle)
    {
        $this->plateNo = $vehicle->getPlateNo();
        $this->type = $vehicle->getType();
    }


}