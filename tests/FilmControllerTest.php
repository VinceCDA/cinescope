<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FilmControllerTest extends WebTestCase
{
    public function testPublicCanAccessFlims(): void
    {
        $client = static::createClient();
        $client->request('GET', '/films');
        $this->assertResponseStatusCodeSame(200);
    }
    public function testPublicCanAccessFlimsId(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/films/1');
        $this->assertResponseStatusCodeSame(200);
        $this->assertGreaterThan(0, $crawler->filter('td:contains("TestPlateforme")')->count());
    }
}
