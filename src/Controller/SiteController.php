<?php

namespace App\Controller;

use App\Repository\DisciplineRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'site_')]
final class SiteController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('site/index.html.twig');
    }

    #[Route('/discipline', name: 'disciplines', methods: ['GET'])]
    public function discipline(Request $request, DisciplineRepository $repository): Response
    {
        $disciplines = new Pagerfanta(new QueryAdapter($repository->findAllPaginatedQueryBuilder()));
        $disciplines->setMaxPerPage(10);
        $disciplines->setCurrentPage($request->query->get('page', 1));

        return $this->render('site/discipline/index.html.twig', [
            'disciplines' => $disciplines,
        ]);
    }

    #[Route('/discipline/{id}', name: 'discipline_show', methods: ['GET'])]
    public function disciplineShow(DisciplineRepository $repository, int $id): Response
    {
        $discipline = $repository->find($id);

        if (!$discipline) {
            throw $this->createNotFoundException('Discipline not found');
        }

        return $this->render('site/discipline/show.html.twig', [
            'discipline' => $discipline,
        ]);
    }

    #[Route('/ranking', name: 'ranking')]
    public function ranking(): Response
    {
        // This is a placeholder for the ranking page logic.
        // You can implement the logic to fetch and display rankings here.

        return $this->render('site/ranking.html.twig');
    }
}
