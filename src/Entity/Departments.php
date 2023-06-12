<?php

namespace App\Entity;

use App\Repository\DepartmentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentsRepository::class)]
class Departments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $countriesId = null;

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

    public function getCountriesId(): ?int
    {
        return $this->countriesId;
    }

    public function setCountriesId(int $countriesId): self
    {
        $this->countriesId = $countriesId;

        return $this;
    }
}
