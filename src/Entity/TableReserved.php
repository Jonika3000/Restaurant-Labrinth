<?php

namespace App\Entity;

use App\Repository\TableReservedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableReservedRepository::class)]
class TableReserved
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $numberofPeople = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\ManyToOne(inversedBy: 'tableReserveds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Table $tableToReserve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getNumberofPeople(): ?int
    {
        return $this->numberofPeople;
    }

    public function setNumberofPeople(int $numberofPeople): static
    {
        $this->numberofPeople = $numberofPeople;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getTableToReserve(): ?Table
    {
        return $this->tableToReserve;
    }

    public function setTableToReserve(?Table $tableToReserve): static
    {
        $this->tableToReserve = $tableToReserve;

        return $this;
    }
}
