<?php

namespace App\Tests;

use App\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Helper\TestEntityFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFilmControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $em = static::getContainer()->get(EntityManagerInterface::class);
        $hasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        $user = TestEntityFactory::createAdminUser($em, $hasher);
        $plateforme1 = TestEntityFactory::createPlateforme($em);
        $plateforme2 = TestEntityFactory::createPlateforme($em);
        $titre = 'Titre' . uniqid();
        $synospis = 'Synopsis' . uniqid();
        $dateSortie = 2000;
        $client->loginUser($user);
        $crawler = $client->request('GET', '/admin/films/new');
        $token = $crawler->filter('#film__token')->attr('value');
        $client->request('POST', '/admin/films/new', [
            'film' => [
                'titre' => $titre,
                'synopsis' => $synospis,
                'dateSortie' => $dateSortie,
                'plateformes' => [
                    (string) $plateforme1->getId(),
                    (string) $plateforme2->getId()
                ],
                '_token' => $token,
            ],
        ]);
        $this->assertResponseRedirects('/admin/films');
        $repo = $em->getRepository(Film::class);
        $film = $repo->findOneBy(['titre' => $titre]);
        self::assertNotNull($film);
        $tab = [];
        foreach ($film->getPlateformes() as $value) {
            array_push($tab, $value->getId());
        }
        $tabCat = [$plateforme1->getId(), $plateforme2->getId()];
        $tabDiff = array_diff($tab, $tabCat);
        self::assertEmpty($tabDiff);
    }
}
