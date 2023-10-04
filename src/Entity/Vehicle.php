<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gears = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $enginePower = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $state = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mileageFromOdometer = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $equipments = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $guarantee = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $images = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $carac1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $carac2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $carac3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $carac4 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getGears(): ?string
    {
        return $this->gears;
    }

    public function setGears(?string $gears): static
    {
        $this->gears = $gears;

        return $this;
    }

    public function getEnginePower(): ?string
    {
        return $this->enginePower;
    }

    public function setEnginePower(?string $enginePower): static
    {
        $this->enginePower = $enginePower;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getMileageFromOdometer(): ?string
    {
        return $this->mileageFromOdometer;
    }

    public function setMileageFromOdometer(?string $mileageFromOdometer): static
    {
        $this->mileageFromOdometer = $mileageFromOdometer;

        return $this;
    }

    public function getEquipments(): ?string
    {
        return $this->equipments;
    }

    public function setEquipments(?string $equipments): static
    {
        $this->equipments = $equipments;

        return $this;
    }

    public function getGuarantee(): ?string
    {
        return $this->guarantee;
    }

    public function setGuarantee(?string $guarantee): static
    {
        $this->guarantee = $guarantee;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCarac1(): ?string
    {
        return $this->carac1;
    }

    public function setCarac1(?string $carac1): static
    {
        $this->carac1 = $carac1;

        return $this;
    }

    public function getCarac2(): ?string
    {
        return $this->carac2;
    }

    public function setCarac2(?string $carac2): static
    {
        $this->carac2 = $carac2;

        return $this;
    }

    public function getCarac3(): ?string
    {
        return $this->carac3;
    }

    public function setCarac3(?string $carac3): static
    {
        $this->carac3 = $carac3;

        return $this;
    }

    public function getCarac4(): ?string
    {
        return $this->carac4;
    }

    public function setCarac4(?string $carac4): static
    {
        $this->carac4 = $carac4;

        return $this;
    }
}
