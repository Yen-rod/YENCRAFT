<?php

namespace App\DataFixtures;

use App\Entity\Producto;
use App\Entity\Categoria;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Crear categorías
        $categoria1 = new Categoria();
        $categoria1->setNombre('Lámparas');
        $manager->persist($categoria1);

        $categoria2 = new Categoria();
        $categoria2->setNombre('Cuadros');
        $manager->persist($categoria2);

       // Crear productos
       $producto1 = new Producto();
       $producto1->setNombre('Lámpara de Madera');
       $producto1->setPrecio(45.99);
       $producto1->setCategoria($categoria1); // Relación con la categoría
       $producto1->setImagen('uploads/images/productos/lampara_madera.jpg'); // Asignar una imagen
       $manager->persist($producto1);

       $producto2 = new Producto();
       $producto2->setNombre('Cuadro de Roble');
       $producto2->setPrecio(75.50);
       $producto2->setCategoria($categoria2); // Relación con la categoría
       $producto2->setImagen('uploads/images/productos/cuadro_roble.jpg'); // Asignar una imagen
       $manager->persist($producto2);

        $manager->flush();
    }
}

