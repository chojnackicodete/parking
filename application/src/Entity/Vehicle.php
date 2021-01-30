<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
class Vehicle
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
    private $size;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=ParkingSlot::class, mappedBy="vehicle")
     */
    private $parkingSlots;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $plateNo;

    public function __construct()
    {
        $this->parkingSlots = new ArrayCollection();
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

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|ParkingSlot[]
     */
    public function getParkingSlots(): Collection
    {
        return $this->parkingSlots;
    }

    public function addParkingSlot(ParkingSlot $parkingSlot): self
    {
        if (!$this->parkingSlots->contains($parkingSlot)) {
            $this->parkingSlots[] = $parkingSlot;
            $parkingSlot->setVehicle($this);
        }

        return $this;
    }

    public function removeParkingSlot(ParkingSlot $parkingSlot): self
    {
        if ($this->parkingSlots->removeElement($parkingSlot)) {
            // set the owning side to null (unless already changed)
            if ($parkingSlot->getVehicle() === $this) {
                $parkingSlot->setVehicle(null);
            }
        }

        return $this;
    }

    public function getPlateNo(): ?string
    {
        return $this->plateNo;
    }

    public function setPlateNo(string $plateNo): self
    {
        $this->plateNo = $plateNo;

        return $this;
    }

}
