<?php

namespace App\Twig\Components;

use App\Entity\Client;
use App\Entity\Order;
use App\Repository\ClientRepository;
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

//    #[LiveProp(writable: true)]
//    #[NotBlank]
//    public \DateTime $orderedAt;

    #[LiveProp(writable: true)]
    public ?int $refId;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public ?Client $client;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public ?string $designation;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public ?int $itemCount;


    #[ExposeInTemplate]
    public function getClients(): array
    {
        return $this->clientRepository->findAll();
    }

    #[LiveListener('client:created')]
    public function onCategoryCreated(#[LiveArg] Client $client): void
    {
        $this->client = $client;
    }

    public function isCurrentClient(Client $client): bool
    {
        return $this->client && $this->client === $client;
    }

    #[LiveAction]
    public function saveOrder(EntityManagerInterface $entityManager): Response
    {
        $this->validate();
        $order = new Order();
        $order->setRefId($this->refId);
        $order->setOrderedAt(\DateTimeImmutable::createFromMutable(new \DateTime()));
        $order->setOrderedBy($this->client);
        $order->setDesignation($this->designation);
        $order->setItemCount($this->itemCount);

        $entityManager->persist($order);
        $entityManager->flush();

        $this->addFlash('live_demo_success', 'Product created! Add another one!');

        return $this->redirectToRoute('app_order_index');
    }
}
