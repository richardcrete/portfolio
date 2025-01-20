<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function root(Request $request): RedirectResponse
    {
        return $this->redirectToRoute('home', [
            '_locale' => $request->getPreferredLanguage($this->getParameter('app_locales_array')),
        ], 301);
    }

    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'projects' => $projectRepository->getProjects(),
            ]
        );
    }
}