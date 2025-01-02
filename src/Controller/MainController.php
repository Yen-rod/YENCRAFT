<?php

namespace App\Controller;
use App\Repository\ProductoRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'inicio')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/tienda', name: 'main_tienda')]
    public function tienda(ProductoRepository $productoRepository): Response
{
    $productos = $productoRepository->findAll();

    return $this->render('main/tienda.html.twig', [
        'productos' => $productos,
    ]);
}

    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('main/blog.html.twig');
    }
}

