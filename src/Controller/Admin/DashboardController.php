<?php

namespace App\Controller\Admin;

use App\Entity\Ad;
use App\Entity\Category;
use App\Entity\Floor;
use App\Entity\StandbyMode;
use App\Entity\Tenant;
use App\Entity\Terminal;
use App\Entity\Updates;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    #[Route(path: '/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CategoryCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Админ-панель')
            ->setFaviconPath('favicon.ico')
            ->renderContentMaximized();
    }

    public function __construct(){}

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Арендаторы');
            yield MenuItem::linkToCrud('Категории', 'fas fa-ticket', Category::class);
            yield MenuItem::linkToCrud('Арендаторы', 'fas fa-handshake', Tenant::class);

        yield MenuItem::section('Карта');
            yield MenuItem::linkToCrud('Терминалы', 'fas fa-terminal', Terminal::class);
            yield MenuItem::linkToCrud('Режим ожидания', 'fas fa-tv', StandbyMode::class);
            yield MenuItem::linkToCrud('Реклама', 'fas fa-ad', Ad::class);
            yield MenuItem::linkToCrud('Этажи', 'fas fa-building', Floor::class);

        yield MenuItem::section('Софт');
            yield MenuItem::linkToCrud('Обновления', 'fas fa-wrench', Updates::class);
            yield MenuItem::section('Настройки');
            yield MenuItem::linkToUrl('API', 'fa fa-link', '/api')
                ->setLinkTarget('_blank')
                ->setPermission('ROLE_ADMIN');
            yield MenuItem::linkToCrud('Пользователи', 'fa fa-users', User::class);
    }
}

