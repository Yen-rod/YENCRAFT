<?php

namespace App\Controller;
use App\Repository\ProductoRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/tienda', name: 'main_tienda')]
    public function tienda(ProductoRepository $productoRepository): Response
{
    //productos desde la bd
    $productos = $productoRepository->findAll(); 
    //pasar los productos a la plantilla
    return $this->render('main/tienda.html.twig', [
        'productos' => $productos,
    ]);
}

    #[Route('/blog', name: 'main_blog')]
    public function blog(): Response
    {
        //Simular artículos del blog 
        $posts = [
            ['titulo' => 'Cómo cuidar tus muebles de madera', 'fecha' => '2025-01-10'],
            ['titulo' => 'Decoración minimalista con madera', 'fecha' => '2025-01-12'],
        ];

        return $this->render('main/blog.html.twig', [
            'posts' => $posts,
        ]);
    }
}

