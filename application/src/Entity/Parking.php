<?php

namespace App\Entity;

use App\Repository\ParkingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParkingRepository::class)
 */
class Parking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var Collection|ParkingRow[]
     * @ORM\OneToMany(targetEntity=ParkingRow::class, mappedBy="parking", orphanRemoval=true, cascade={"persist"})
     */
    private Collection $parkingRows;

    public function __construct()
    {
        $this->parkingRows = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ParkingRow[]
     */
    public function getParkingRows(): Collection
    {
        return $this->parkingRows;
    }

    public function addParkingRow(ParkingRow $parkingRow): self
    {
        if (!$this->parkingRows->contains($parkingRow)) {
            $this->parkingRows[] = $parkingRow;
            $parkingRow->setParking($this);
        }

        return $this;
    }

    public function removeParkingRow(ParkingRow $parkingRow): self
    {
        if ($this->parkingRows->removeElement($parkingRow)) {
            // set the owning side to null (unless already changed)
            if ($parkingRow->getParking() === $this) {
                $parkingRow->setParking(null);
            }
        }

        return $this;
    }
}
