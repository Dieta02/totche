<?php

namespace App\Entity;

use App\Repository\SitesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SitesRepository::class)]
class Sites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private array $pictures = [];

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $map = null;

    #[ORM\Column(nullable: true)]
    private ?int $rate = null;

    #[ORM\Column(nullable: true)]
    private ?int $visits = null;

    #[ORM\Column]
    private ?int $phoneNumber = null;

    #[ORM\Column(nullable: true)]
    private array $socials = [];

    #[ORM\Column]
    private ?int $categoriesId = null;

    #[ORM\Column]
    private ?int $countriesId = null;

    #[ORM\Column]
    private ?int $departmentsId = null;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPictures(): array
    {
        return $this->pictures;
    }

    public function setPictures(array $pictures): self
    {
        $this->pictures = $pictures;

        return $this;
    }

    public function getMap(): ?string
    {
        return $this->map;
    }

    public function setMap(string $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getVisits(): ?int
    {
        return $this->visits;
    }

    public function setVisits(?int $visits): self
    {
        $this->visits = $visits;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

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

    public function getCategoriesId(): ?int
    {
        return $this->categoriesId;
    }

    public function setCategoriesId(int $categoriesId): self
    {
        $this->categoriesId = $categoriesId;

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

    public function getDepartmentsId(): ?int
    {
        return $this->departmentsId;
    }

    public function setDepartmentsId(int $departmentsId): self
    {
        $this->departmentsId = $departmentsId;

        return $this;
    }
}
