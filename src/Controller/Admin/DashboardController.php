<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Event;
use App\Entity\SiteLocale;
use App\Entity\Table;
use App\Entity\TableReserved;
use App\Entity\Translate\CategoryTranslate;
use App\Entity\Translate\DishTranslate;
use App\Entity\Translate\EventTranslate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Restaurant Labrinth');
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-gauge');
        yield MenuItem::linkToCrud('Category', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Dish', 'fa-solid fa-bowl-food', Dish::class);
        yield MenuItem::linkToCrud('Event', 'fa-solid fa-champagne-glasses', Event::class);
        yield MenuItem::linkToCrud('Table', 'fa-solid fa-chair', Table::class);
        yield MenuItem::linkToCrud('Reserved Tables', 'fa-solid fa-utensils', TableReserved::class);
        yield MenuItem::linkToCrud('Locale', 'fa-solid fa-earth-americas', SiteLocale::class);
        yield MenuItem::subMenu('Translates', 'fa-solid fa-language')->setSubItems([
            MenuItem::linkToCrud('Category', 'fas fa-tags', CategoryTranslate::class),
            MenuItem::linkToCrud('Dish', 'fa-solid fa-bowl-food', DishTranslate::class),
            MenuItem::linkToCrud('Event', 'fa-solid fa-champagne-glasses', EventTranslate::class)
        ]);
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'app_homepage');
    }
}
