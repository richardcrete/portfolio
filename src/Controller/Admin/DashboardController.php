<?php

namespace App\Controller\Admin;

use App\Entity\Diploma;
use App\Entity\Experience;
use App\Entity\Project;
use App\Entity\Tool;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private readonly AdminUrlGenerator $adminUrlGenerator)
    {
    }

    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->adminUrlGenerator;

        return $this->redirect($routeBuilder->setController(ProjectCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Admin');
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Projects', 'fas fa-code', Project::class);
        yield MenuItem::linkToCrud('Experiences ', 'fas fa-briefcase', Experience::class);
        yield MenuItem::linkToCrud('Tools', 'fas fa-screwdriver-wrench', Tool::class);
        yield MenuItem::linkToCrud('Diplomas', 'fas fa-graduation-cap', Diploma::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
    }
}
