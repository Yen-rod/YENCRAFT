<?php

namespace App\Controller;
use App\Entity\Pedido;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;


class PedidoController extends AbstractController
{
    #[Route('/pedido', name: 'app_pedido')]
    public function index(): Response
    {
        return $this->render('pedido/index.html.twig', [
            'controller_name' => 'PedidoController',
        ]);
    }

    #[Route('/historial', name: 'app_pedido_historial', methods: ['GET'])]
    public function historial(EntityManagerInterface $entityManager): Response
    {
    // Obtener los pedidos del usuario autenticado
    $pedidos = $entityManager->getRepository(Pedido::class)
        ->findBy(['usuario' => $this->getUser()]);

    return $this->render('pedido/historial.html.twig', [
        'pedidos' => $pedidos,
    ]);
    }

}
