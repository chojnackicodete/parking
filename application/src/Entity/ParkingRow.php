<?php

namespace App\Entity;

use App\Repository\ParkingRowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ParkingRowRepository::class)
 */
class ParkingRow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Parking", inversedBy="ParkingRows", cascade={"persist"})
     * @ORM\JoinColumn(name="parking_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $parking;

    /**
     * @var Collection|ParkingRow[]
     * @ORM\OneToMany(targetEntity=ParkingSlot::class, mappedBy="parkingRow", orphanRemoval=true, cascade={"persist"})
     */
    private Collection $parkingSlots;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $alpha;

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

    /**
     * @return mixed
     */
    public function getParking(): Parking
    {
        return $this->parking;
    }

    /**
     * @param Parking $parking
     */
    public function setParking(Parking $parking): self
    {
        $this->parking = $parking;
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
            $parkingSlot->setParkingRow($this);
        }

        return $this;
    }

    public function removeParkingSlot(ParkingSlot $parkingSlot): self
    {
        if ($this->parkingSlots->removeElement($parkingSlot)) {
            // set the owning side to null (unless already changed)
            if ($parkingSlot->getParkingRow() === $this) {
                $parkingSlot->setParkingRwo(null);
            }
        }

        return $this;
    }

    public function getAlpha(): ?string
    {
        return $this->alpha;
    }

    public function setAlpha(?string $alpha): self
    {
        $this->alpha = $alpha;

        return $this;
    }
}
