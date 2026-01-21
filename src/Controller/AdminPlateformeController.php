<?php

namespace App\Controller;

use App\Entity\Plateforme;
use App\Form\PlateformeType;
use App\Repository\PlateformeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/plateforme')]
final class AdminPlateformeController extends AbstractController
{
    #[Route(name: 'app_admin_plateforme_index', methods: ['GET'])]
    public function index(PlateformeRepository $plateformeRepository): Response
    {
        return $this->render('admin_plateforme/index.html.twig', [
            'plateformes' => $plateformeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_plateforme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plateforme = new Plateforme();
        $form = $this->createForm(PlateformeType::class, $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plateforme);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_plateforme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_plateforme/new.html.twig', [
            'plateforme' => $plateforme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_plateforme_show', methods: ['GET'])]
    public function show(Plateforme $plateforme): Response
    {
        return $this->render('admin_plateforme/show.html.twig', [
            'plateforme' => $plateforme,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_plateforme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plateforme $plateforme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlateformeType::class, $plateforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_plateforme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_plateforme/edit.html.twig', [
            'plateforme' => $plateforme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_plateforme_delete', methods: ['POST'])]
    public function delete(Request $request, Plateforme $plateforme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plateforme->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($plateforme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_plateforme_index', [], Response::HTTP_SEE_OTHER);
    }
}
