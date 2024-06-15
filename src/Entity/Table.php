<?php

namespace App\Entity;

use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?int $maxPeopleCount = null;

    #[ORM\Column]
    private ?int $minPeopleCount = null;

    /**
     * @var Collection<int, TableReserved>
     */
    #[ORM\OneToMany(targetEntity: TableReserved::class, mappedBy: 'tableToReserve')]
    private Collection $tableReserveds;

    public function __construct()
    {
        $this->tableReserveds = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->number;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getMaxPeopleCount(): ?int
    {
        return $this->maxPeopleCount;
    }

    public function setMaxPeopleCount(int $maxPeopleCount): static
    {
        $this->maxPeopleCount = $maxPeopleCount;

        return $this;
    }

    public function getMinPeopleCount(): ?int
    {
        return $this->minPeopleCount;
    }

    public function setMinPeopleCount(int $minPeopleCount): static
    {
        $this->minPeopleCount = $minPeopleCount;

        return $this;
    }

    /**
     * @return Collection<int, TableReserved>
     */
    public function getTableReserveds(): Collection
    {
        return $this->tableReserveds;
    }

    public function addTableReserved(TableReserved $tableReserved): static
    {
        if (!$this->tableReserveds->contains($tableReserved)) {
            $this->tableReserveds->add($tableReserved);
            $tableReserved->setTableToReserve($this);
        }

        return $this;
    }

    public function removeTableReserved(TableReserved $tableReserved): static
    {
        if ($this->tableReserveds->removeElement($tableReserved)) {
            // set the owning side to null (unless already changed)
            if ($tableReserved->getTableToReserve() === $this) {
                $tableReserved->setTableToReserve(null);
            }
        }

        return $this;
    }
}
