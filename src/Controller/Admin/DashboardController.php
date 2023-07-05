<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Transporteur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private $adminUrlGenerator;
    public function __construct(AdminUrlGenerator $aug){
        $this->adminUrlGenerator = $aug;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $url = $this->adminUrlGenerator->setController(UserCrudController::class)->generateUrl();
        return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FilRouge2');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('delicious');
        yield MenuItem::subMenu('les utilisateurs', 'fa-solid fa-users', user::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter','fa-solid fa-plus', User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser','fa fa-eye', User::class),

            ]);
        yield MenuItem::linkToCrud('les adresses', 'fa-solid fa-address-card', Adresse::class);
        yield MenuItem::linkToCrud('les catégories', 'fa-solid fa-bookmark', Category::class);
        yield MenuItem::linkToCrud('les produits', 'fa-solid fa-cart-shopping', Product::class);
        yield MenuItem::linkToCrud('les transporteur', 'fa-solid fa-bus', Transporteur::class);
    }
}
