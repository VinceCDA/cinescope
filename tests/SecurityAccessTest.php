<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Helper\TestEntityFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityAccessTest extends WebTestCase
{
    public function testUnloggedUserCantAccessAdmin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');
        $this->assertResponseRedirects('/login', 302);
    }
    public function testLoggedUserCantAccessAdmin(): void
    {
        $client = static::createClient();
        $em = static::getContainer()->get(EntityManagerInterface::class);
        $hasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        $user = TestEntityFactory::createUser($em, $hasher);
        $client->loginUser($user);
        $client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(403);
    }
    public function testLoggedAdminCanAccessAdmin(): void
    {
        $client = static::createClient();
        $em = static::getContainer()->get(EntityManagerInterface::class);
        $hasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        $user = TestEntityFactory::createAdminUser($em, $hasher);
        $client->loginUser($user);
        $client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(200);
    }
}
