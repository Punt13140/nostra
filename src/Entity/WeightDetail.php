<?php

namespace App\Entity;

use App\Repository\WeightDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeightDetailRepository::class)]
class WeightDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $platinum = null;

    #[ORM\Column(nullable: true)]
    private ?float $gold = null;

    #[ORM\Column(nullable: true)]
    private ?float $silver = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ObjectType $type = null;

    #[ORM\ManyToOne(inversedBy: 'weightDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $refOrder = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deliveredAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlatinum(): ?float
    {
        return $this->platinum;
    }

    public function setPlatinum(?float $platinum): static
    {
        $this->platinum = $platinum;

        return $this;
    }

    public function getGold(): ?float
    {
        return $this->gold;
    }

    public function setGold(?float $gold): static
    {
        $this->gold = $gold;

        return $this;
    }

    public function getSilver(): ?float
    {
        return $this->silver;
    }

    public function setSilver(?float $silver): static
    {
        $this->silver = $silver;

        return $this;
    }

    public function getType(): ?ObjectType
    {
        return $this->type;
    }

    public function setType(?ObjectType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getRefOrder(): ?Order
    {
        return $this->refOrder;
    }

    public function setRefOrder(?Order $refOrder): static
    {
        $this->refOrder = $refOrder;

        return $this;
    }

    public function getDeliveredAt(): ?\DateTimeImmutable
    {
        return $this->deliveredAt;
    }

    public function setDeliveredAt(?\DateTimeImmutable $deliveredAt): static
    {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }
}
