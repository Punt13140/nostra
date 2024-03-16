<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\WeightDetail;
use App\Repository\ObjectTypeRepository;
use App\Repository\OrderRepository;
use App\Repository\WeightDetailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order_index', defaults: ['page' => 1], methods: ['GET'])]
    #[Route('/order/page/{page<[1-9]\d{0,8}>}', name: 'app_order_paginated', defaults: ['page' => 1], methods: ['GET'])]
    public function index(OrderRepository $orderRepository, int $page): Response
    {
        return $this->render('order/index.html.twig', [
            'paginator' => $orderRepository->findLatest($page),
        ]);
    }

    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ObjectTypeRepository $objectTypeRepository): Response
    {
        $order = new Order();
        $weightDetailFabricants = new WeightDetail();
        $weightDetailOccasions = new WeightDetail();
        $weightDetailOthers = new WeightDetail();
        $weightDetailTiers = new WeightDetail();

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'weightDetailOccasions' => $weightDetailOccasions,
            'weightDetailFabricants' => $weightDetailFabricants,
            'weightDetailAutres' => $weightDetailOthers,
            'weightDetailTiers' => $weightDetailTiers,
        ]);
    }

    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager, WeightDetailRepository $weightDetailRepository, ObjectTypeRepository $objectTypeRepository): Response
    {
        return $this->render('order/edit.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
