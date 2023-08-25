<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
class Speciality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Le nom de la spécialité ne peut pas être vide')]
    #[Assert\Length(min: 6, max: 100,
        minMessage: 'Le nom de la spécialité doit contenir au moins 6 caractères',
        maxMessage: 'Le nom de la spécialité doit contenir au plus 100 caractères')]
    private ?string $nameSpeciality = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'La durée ne peut pas être vide')]
    #[Assert\PositiveOrZero(message: 'La durée doit être positive en minutes')]
    private ?int $duration = null;

    #[ORM\ManyToMany(targetEntity: Hairdresser::class, inversedBy: 'specialities')]
    private Collection $hairdresser;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Pictures $picture = null;

    #[ORM\Column]
    private ?float $rate = null;

    #[ORM\OneToMany(mappedBy: 'speciality', targetEntity: Booking::class)]
    private Collection $bookings;

    public function __construct()
    {
        $this->hairdresser = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameSpeciality(): ?string
    {
        return $this->nameSpeciality;
    }

    public function setNameSpeciality(string $nameSpeciality): static
    {
         $this->nameSpeciality = $nameSpeciality;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Hairdresser>
     */
    public function getHairdresser(): Collection
    {
        return $this->hairdresser;
    }

    public function addHairdresser(Hairdresser $hairdresser): static
    {
        if (!$this->hairdresser->contains($hairdresser)) {
            $this->hairdresser->add($hairdresser);
        }

        return $this;
    }

    public function removeHairdresser(Hairdresser $hairdresser): static
    {
        $this->hairdresser->removeElement($hairdresser);

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPicture(): ?pictures
    {
        return $this->picture;
    }

    public function setPicture(?pictures $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setSpeciality($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getSpeciality() === $this) {
                $booking->setSpeciality(null);
            }
        }

        return $this;
    }
}
