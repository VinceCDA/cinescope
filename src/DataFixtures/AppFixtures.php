<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Plateforme;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        (int) $nbTest = 10;
        for ($i = 0; $i < $nbTest; $i++) {
            # code...
        }
        $plateforme1 = new Plateforme();
        $plateforme1->setName('TestPlateforme1');
        $plateforme1->setLogo('TestLogo1');
        $plateforme1->setUrl('test_url_plat1');

        $plateforme2 = new Plateforme();
        $plateforme2->setName('TestPlateforme2');
        $plateforme2->setLogo('TestLogo2');
        $plateforme2->setUrl('test_url_plat2');

        $film = new Film();
        $film->setTitre('FilmTest01');
        $film->setSynopsis('SynopsisTestFilm01');
        $film->setDateSortie(2000);
        $film->addPlateforme($plateforme1);
        $film->addPlateforme($plateforme2);

        $manager->persist($plateforme1);
        $manager->persist($plateforme2);
        $manager->persist($film);
        
        $manager->flush();
    }
}
