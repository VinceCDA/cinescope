<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FilmControllerTest extends WebTestCase
{
    public function publicCanAccessFlims(): void
    {
        $client = static::createClient();
        $client->request('GET', '/films');
        $this->assertResponseStatusCodeSame(200);
    }
}
