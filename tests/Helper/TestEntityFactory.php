<?php

namespace App\Tests\Helper;

use App\Entity\Plateforme;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class TestEntityFactory
{
    public static function createUser(EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface, ?string $email = null, string $plainPassword = "pass_1234"): User
    {
        $user = new User();
        $user->setEmail($email ?? ('user' . uniqid() . '@test.local'));
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($userPasswordHasherInterface->hashPassword($user, $plainPassword));
        $entityManagerInterface->persist($user);
        $entityManagerInterface->flush();
        return $user;
    }
    public static function createAdminUser(EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface, ?string $email = null, string $plainPassword = "pass_1234"): User
    {
        $user = new User();
        $user->setEmail($email ?? ('user' . uniqid() . '@test.local'));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setPassword($userPasswordHasherInterface->hashPassword($user, $plainPassword));
        $entityManagerInterface->persist($user);
        $entityManagerInterface->flush();
        return $user;
    }
    public static function createPlateforme(EntityManagerInterface $entityManagerInterface, ?string $nom = null, ?string $slug = null):Plateforme{
        $plateforme = new Plateforme();
        $plateforme->setName($nom ?? ('Name '.uniqid()));
        $plateforme->setLogo($slug ?? ('logo'.uniqid()));
        $plateforme->setUrl($slug ?? ('url_'.uniqid()));
        if (method_exists($categorie,'setCreatedAt')) {
            $categorie->setCreatedAt(new DateTimeImmutable());
        }
        $entityManagerInterface->persist($categorie);
        $entityManagerInterface->flush();
        return $categorie;
    }
}
