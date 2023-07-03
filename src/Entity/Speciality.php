<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
class Speciality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nameSpeciality = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\ManyToMany(targetEntity: Hairdresser::class, inversedBy: 'specialities')]
    private Collection $hairdresser;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?pictures $picutre = null;

    public function __construct()
    {
        $this->hairdresser = new ArrayCollection();
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

    public function getPicutre(): ?pictures
    {
        return $this->picutre;
    }

    public function setPicutre(?pictures $picutre): static
    {
        $this->picutre = $picutre;

        return $this;
    }
}
