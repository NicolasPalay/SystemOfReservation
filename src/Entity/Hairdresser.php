<?php

namespace App\Entity;

use App\Repository\HairdresserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HairdresserRepository::class)]
class Hairdresser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'hairdresser', cascade: ['persist', 'remove'])]
    private ?User $User = null;

    #[ORM\ManyToMany(targetEntity: Speciality::class, mappedBy: 'hairdresser')]
    private Collection $specialities;

    #[ORM\OneToOne(inversedBy: 'hairdresser', cascade: ['persist', 'remove'])]
    private ?Pictures $picture = null;

    #[ORM\OneToMany(mappedBy: 'hairdresser', targetEntity: Booking::class)]
    private Collection $bookings;

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addSpeciality(Speciality $speciality): static
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities->add($speciality);
            $speciality->addHairdresser($this);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): static
    {
        if ($this->specialities->removeElement($speciality)) {
            $speciality->removeHairdresser($this);
        }

        return $this;
    }

    public function getPicture(): ?Pictures
    {
        return $this->picture;
    }

    public function setPicture(?Pictures $picture): static
    {
        $this->picture = $picture;

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
            $booking->setHairdresser($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getHairdresser() === $this) {
                $booking->setHairdresser(null);
            }
        }

        return $this;
    }
}
