<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;


    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $client = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Hairdresser $hairdresser = null;

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

       public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getHairdresser(): ?Hairdresser
    {
        return $this->hairdresser;
    }

    public function setHairdresser(?Hairdresser $hairdresser): static
    {
        $this->hairdresser = $hairdresser;

        return $this;
    }
}
