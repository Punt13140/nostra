<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column]
    private ?\DateTimeImmutable $orderedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $designation = null;

    #[ORM\Column]
    private ?int $itemCount = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $observation = null;

    #[ORM\Column(nullable: true)]
    private ?int $refId = null;

    #[ORM\OneToMany(mappedBy: 'refOrder', targetEntity: WeightDetail::class, orphanRemoval: true)]
    private Collection $weightDetails;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $exitedAt = null;

    public function __construct()
    {
        $this->weightDetails = new ArrayCollection();
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

    public function getOrderedAt(): ?\DateTimeImmutable
    {
        return $this->orderedAt;
    }

    public function setOrderedAt(\DateTimeImmutable $orderedAt): static
    {
        $this->orderedAt = $orderedAt;

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

    /**
     * @return Collection<int, WeightDetail>
     */
    public function getWeightDetails(): Collection
    {
        return $this->weightDetails;
    }

    public function addWeightDetail(WeightDetail $weightDetail): static
    {
        if (!$this->weightDetails->contains($weightDetail)) {
            $this->weightDetails->add($weightDetail);
            $weightDetail->setRefOrder($this);
        }

        return $this;
    }

    public function removeWeightDetail(WeightDetail $weightDetail): static
    {
        if ($this->weightDetails->removeElement($weightDetail)) {
            // set the owning side to null (unless already changed)
            if ($weightDetail->getRefOrder() === $this) {
                $weightDetail->setRefOrder(null);
            }
        }

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
}
