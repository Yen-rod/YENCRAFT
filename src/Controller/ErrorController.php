<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class ErrorController extends AbstractController
{
    public function show404(): Response
    {
        return $this->render('error/404.html.twig', [], new Response('', 404));
    }

    //se añade a la par que se crea este controlador una ruta de error personalizada en config/routes.yaml
    //tambien sobreescribimos en config/packages/framework.yaml para que haga uso de la función show404
}
