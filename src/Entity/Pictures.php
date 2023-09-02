<?php

namespace App\Entity;

use App\Repository\PicturesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PicturesRepository::class)]
class Pictures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?Book $book = null;


    #[ORM\OneToOne(mappedBy: "picture")]
    private ?Speciality $speciality = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getHairdresser(): ?Hairdresser
    {
        return $this->hairdresser;
    }

    public function setHairdresser(?Hairdresser $hairdresser): static
    {
        // unset the owning side of the relation if necessary
        if ($hairdresser === null && $this->hairdresser !== null) {
            $this->hairdresser->setPicture(null);
        }

        // set the owning side of the relation if necessary
        if ($hairdresser !== null && $hairdresser->getPicture() !== $this) {
            $hairdresser->setPicture($this);
        }

        $this->hairdresser = $hairdresser;

        return $this;
    }


}
