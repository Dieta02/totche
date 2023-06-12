<?php

namespace App\Entity;

use App\Repository\GuidesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuidesRepository::class)]
class Guides
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column]
    private ?int $phoneNumber = null;

    #[ORM\Column]
    private ?int $countriesId = null;

    #[ORM\Column(nullable: true)]
    private array $socials = [];

    #[ORM\Column(length: 255)]
    private ?string $profilPicture = null;

    #[ORM\Column(nullable: true)]
    private array $pictures = [];

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }


    public function getCountriesId(): ?int
    {
        return $this->countriesId;
    }

    public function setCountriesId(int $countriesId): self
    {
        $this->countriesId = $countriesId;

        return $this;
    }

    public function getSocials(): array
    {
        return $this->socials;
    }

    public function setSocials(?array $socials): self
    {
        $this->socials = $socials;

        return $this;
    }

    public function getProfilPicture(): ?string
    {
        return $this->profilPicture;
    }

    public function setProfilPicture(string $profilPicture): self
    {
        $this->profilPicture = $profilPicture;

        return $this;
    }

    public function getPictures(): array
    {
        return $this->pictures;
    }

    public function setPictures(?array $pictures): self
    {
        $this->pictures = $pictures;

        return $this;
    }
}