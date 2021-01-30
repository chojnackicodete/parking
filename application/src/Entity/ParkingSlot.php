<?php

namespace App\Entity;

use App\Repository\ParkingSlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParkingSlotRepository::class)
 */
class ParkingSlot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\ManyToOne(targetEntity="ParkingRow", inversedBy="ParkingSlots", cascade={"persist"})
     * @ORM\JoinColumn(name="parking_row_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $parkingRow;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicle::class, inversedBy="parkingSlots", cascade={"persist"})
     */
    private ?Vehicle $vehicle;

    public function getParkingRow(): ParkingRow
    {
        return $this->parkingRow;
    }

    public function setParkingRow(ParkingRow $parkingRow): self
    {
        $this->parkingRow = $parkingRow;
        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

}
