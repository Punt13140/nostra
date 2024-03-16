<?php

namespace App\Twig\Components;

use App\Config\Type;
use App\Entity\Client;
use App\Entity\Order;
use App\Entity\WeightDetail;
use App\Repository\ClientRepository;
use App\Repository\ObjectTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class NewOrderForm extends AbstractController
{
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    public function __construct(
        private readonly ClientRepository $clientRepository,
    )
    {
    }

    #[LiveProp(writable: ['refId', 'designation', 'itemCount'])]
    public ?Order $order;

    #[LiveProp(writable: true)]
    public ?string $exitedAt = null;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public ?Client $orderedBy;

    #[LiveProp(writable: ['gold', 'platinum', 'silver',])]
    public ?WeightDetail $weightDetailOccasions;

    #[LiveProp(writable: ['gold', 'platinum', 'silver',])]
    public ?WeightDetail $weightDetailFabricants;

    #[LiveProp(writable: ['gold', 'platinum', 'silver',])]
    public ?WeightDetail $weightDetailOthers;

    #[LiveProp(writable: ['gold', 'platinum', 'silver',])]
    public ?WeightDetail $weightDetailTiers;


    #[ExposeInTemplate]
    public function getClients(): array
    {
        return $this->clientRepository->findAll();
    }

    #[LiveListener('client:created')]
    public function onCategoryCreated(#[LiveArg] Client $client): void
    {
        $this->orderedBy = $client;
    }

    public function isCurrentClient(Client $client): bool
    {
        return $this->orderedBy && $this->orderedBy === $client;
    }

    #[LiveAction]
    public function saveOrder(EntityManagerInterface $entityManager, ObjectTypeRepository $objectTypeRepository): Response
    {
        $this->validate();

        $this->order->setOrderedAt(\DateTimeImmutable::createFromMutable(new \DateTime()));

        if ($this->weightDetailOccasions->getType() == null) {
            $this->weightDetailOccasions->setType($objectTypeRepository->find(Type::occasions));
        }

        if ($this->weightDetailTiers->getType() == null) {
            $this->weightDetailTiers->setType($objectTypeRepository->find(Type::tiers));
        }

        if ($this->weightDetailOthers->getType() == null) {
            $this->weightDetailOthers->setType($objectTypeRepository->find(Type::autres));
        }

        if ($this->weightDetailFabricants->getType() == null) {
            $this->weightDetailFabricants->setType($objectTypeRepository->find(Type::fabricants));
        }

        if ($this->exitedAt != null) {
            $date = \DateTimeImmutable::createFromFormat('Y-m-d', $this->exitedAt);
            if ($date) {
                $this->order->setExitedAt($date);
            }
        }

        if ($this->order->getId() == null) {
            $this->order->setOrderedBy($this->orderedBy);
            $this->order->addWeightDetail($this->weightDetailOccasions);
            $this->order->addWeightDetail($this->weightDetailTiers);
            $this->order->addWeightDetail($this->weightDetailOthers);
            $this->order->addWeightDetail($this->weightDetailFabricants);
        }

        $entityManager->persist($this->order);
        $entityManager->flush();

        $this->addFlash('live_demo_success', 'Product created! Add another one!');

        return $this->redirectToRoute('app_order_index');
    }
}
