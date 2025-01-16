<?php

namespace App\Controller;

use App\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/carrito')]
class CarritoController extends AbstractController
{
    #[Route('/', name: 'app_carrito_index', methods: ['GET'])]
    public function index(SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);

        return $this->render('carrito/index.html.twig', [
            'carrito' => $carrito,
        ]);
    }

    #[Route('/add/{id}', name: 'app_carrito_add', methods: ['GET'])]
    public function add(Producto $producto, SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);
        $carrito[$producto->getId()] = [
            'producto' => $producto,
            'cantidad' => ($carrito[$producto->getId()]['cantidad'] ?? 0) + 1,
        ];
        $session->set('carrito', $carrito);

        return $this->redirectToRoute('main_tienda');
    }

    #[Route('/remove/{id}', name: 'app_carrito_remove', methods: ['GET'])]
    public function remove(int $id, SessionInterface $session): Response
    {
        $carrito = $session->get('carrito', []);
        unset($carrito[$id]);
        $session->set('carrito', $carrito);

        return $this->redirectToRoute('app_carrito_index');
    }
}
