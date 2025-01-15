<?php

namespace App\DataFixtures;

use App\Entity\Usuario; // Asegúrate de usar la entidad correcta
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class UsersFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $passwordHasher; //declarada para mayor claridad

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Crear usuario estándar
        $user = new Usuario();
        $user->setNombre('Elia');
        $user->setEmail('user@example.com'); // Corregido el uso de la propiedad
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $user->setFechaRegistro(new DateTime('now'));
        $manager->persist($user);

        // Crear administrador
        $admin = new Usuario();
        $admin->setNombre('Agostina');
        $admin->setEmail('admin@example.com'); // Corregido el uso de la propiedad
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $admin->setFechaRegistro(new DateTime('now'));
        $manager->persist($admin);

        $manager->flush();
    }

    public static function getGroups(): array   // nombre de grupo de fixtures 
    {                                           // php bin/console doctrine:fixtures:load --group=users
        return ['users'];
    }
}
