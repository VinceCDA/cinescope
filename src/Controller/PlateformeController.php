<?php

namespace App\Controller;

use App\Entity\Plateforme;
use App\Repository\PlateformeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/plateforme')]
final class PlateformeController extends AbstractController
{
    #[Route(name: 'app_plateforme_index', methods: ['GET'])]
    public function index(PlateformeRepository $plateformeRepository): Response
    {
        return $this->render('plateforme/index.html.twig', [
            'plateformes' => $plateformeRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_plateforme_show', methods: ['GET'])]
    public function show(Plateforme $plateforme): Response
    {
        return $this->render('plateforme/show.html.twig', [
            'plateforme' => $plateforme,
        ]);
    }
}
