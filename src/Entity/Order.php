<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $orderedBy = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $orderedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $designation = null;

    #[ORM\Column]
    private ?int $itemCount = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $observation = null;

    #[ORM\Column(nullable: true)]
    private ?int $refId = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $exitedAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?WeightDetail $weightDetailFabricants = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?WeightDetail $weightDetailOccasion = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?WeightDetail $weightDetailOthers = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?WeightDetail $weightDetailTiers = null;

    public function __construct()
    {
        $this->observation = '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderedBy(): ?Client
    {
        return $this->orderedBy;
    }

    public function setOrderedBy(?Client $orderedBy): static
    {
        $this->orderedBy = $orderedBy;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getItemCount(): ?int
    {
        return $this->itemCount;
    }

    public function setItemCount(int $itemCount): static
    {
        $this->itemCount = $itemCount;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }

    public function getRefId(): ?int
    {
        return $this->refId;
    }

    public function setRefId(?int $refId): static
    {
        $this->refId = $refId;

        return $this;
    }

    public function getExitedAt(): ?\DateTimeImmutable
    {
        return $this->exitedAt;
    }

    public function setExitedAt(?\DateTimeImmutable $exitedAt): static
    {
        $this->exitedAt = $exitedAt;

        return $this;
    }

    public function getOrderedAt(): ?\DateTimeImmutable
    {
        return $this->orderedAt;
    }

    public function setOrderedAt(\DateTimeImmutable $orderedAt): static
    {
        $this->orderedAt = $orderedAt;

        return $this;
    }

    public function getWeightDetailFabricants(): ?WeightDetail
    {
        return $this->weightDetailFabricants;
    }

    public function setWeightDetailFabricants(WeightDetail $weightDetailFabricants): static
    {
        $this->weightDetailFabricants = $weightDetailFabricants;

        return $this;
    }

    public function getWeightDetailOccasion(): ?WeightDetail
    {
        return $this->weightDetailOccasion;
    }

    public function setWeightDetailOccasion(WeightDetail $weightDetailOccasion): static
    {
        $this->weightDetailOccasion = $weightDetailOccasion;

        return $this;
    }

    public function getWeightDetailOthers(): ?WeightDetail
    {
        return $this->weightDetailOthers;
    }

    public function setWeightDetailOthers(WeightDetail $weightDetailOthers): static
    {
        $this->weightDetailOthers = $weightDetailOthers;

        return $this;
    }

    public function getWeightDetailTiers(): ?WeightDetail
    {
        return $this->weightDetailTiers;
    }

    public function setWeightDetailTiers(WeightDetail $weightDetailTiers): static
    {
        $this->weightDetailTiers = $weightDetailTiers;

        return $this;
    }
}
