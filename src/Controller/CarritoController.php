<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Pedido;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

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

    //método para confirmar el pedido
    #[Route('/confirmar', name: 'app_carrito_confirmar', methods: ['POST'])]
    public function confirmar(SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
    // Obtener el carrito de la sesión
    $carrito = $session->get('carrito', []);

    // Si el carrito está vacío, redirigir con un mensaje
    if (empty($carrito)) {  //true si la variable carrito está vacia 
        $this->addFlash('error', 'El carrito está vacío.');
        return $this->redirectToRoute('app_carrito_index'); 
    }

    // Crear un nuevo pedido
    $pedido = new Pedido();
    $pedido->setFecha(new \DateTime());

    // Validar que el usuario está autenticado
    if (!$this->getUser()) {
        $this->addFlash('error', 'Debes iniciar sesión para confirmar un pedido.');
        return $this->redirectToRoute('app_login'); // Redirigir a la página de login
    }

    $pedido->setUsuario($this->getUser()); // Asociar el pedido con el usuario autenticado

    // Asociar productos al pedido
    foreach ($carrito as $item) {
        // Cargar el producto desde el repositorio para garantizar que está completamente inicializado
        $producto = $entityManager->getRepository(Producto::class)->find($item['producto']->getId());
    
        // Verificar si el producto existe en la base de datos
        if (!$producto) {
            $this->addFlash('error', 'El producto no existe.');
            return $this->redirectToRoute('app_carrito_index');
        }
    
        $pedido->addProducto($producto);
    }

    // Guardar el pedido en la base de datos
    $entityManager->persist($pedido);
    $entityManager->flush();

    // Vaciar el carrito después de confirmar el pedido
    $session->remove('carrito');

    // Mensaje de confirmación
    $this->addFlash('success', 'Pedido confirmado con éxito.');

    // Redirigir al historial de pedidos
    return $this->redirectToRoute('app_pedido_historial');
    }

}
