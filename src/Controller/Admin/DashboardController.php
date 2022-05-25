<?php

namespace App\Controller\Admin;

use App\Entity\Don;
use App\Entity\Envoye;
use App\Entity\Stock;
use App\Entity\User;
use App\Repository\DonRepository;
use App\Repository\EnvoyeRepository;
use App\Repository\StockRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    private StockRepository $stockRepository;
    private DonRepository $donRepository;
    private EnvoyeRepository $envoyeRepository;

    public function __construct(
        StockRepository $stockRepository,
        DonRepository $donRepository,
        EnvoyeRepository $envoyeRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->donRepository = $donRepository;
        $this->envoyeRepository = $envoyeRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $envoie = $this->envoyeRepository->findBy(["user"=>$this->getUser()], ["createdAt"=>"DESC"],10);

        $don = $this->donRepository->findBy(["user"=> $this->getUser()],["createdAt"=> "DESC"],10);
        $stock = $this->stockRepository->findLast();

        return $this->render('admin/index.html.twig', [
            'stock'=> $stock,
            'don'=> $don,
            'envoie'=> $envoie

        ]);
    }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if (!$user instanceof User){
            throw new Exception('wrong user');
        }

        return parent::configureUserMenu($user)
            ->setAvatarUrl($user->getAvatarUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('French Touch');
    }

    public function configureMenuItems(): iterable
    {


        yield MenuItem::subMenu('Menbres','fas fa-users' )
            ->setSubItems([
                MenuItem::linkToCrud('liste', 'fas fa-list', User::class),
                MenuItem::linkToRoute('modifier mot de pass',"fas fa-key", "app_update_password"),
                MenuItem::linkToRoute('ajouter un menbre', 'fa fa-plus', 'app_register')
                    ->setPermission('ROLE_BANQUE')
            ]);
        yield MenuItem::linkToCrud('Stock', 'fa-solid fa-business-time', Stock::class)
            ->setPermission('ROLE_BANQUE');
        yield MenuItem::linkToCrud('Don', 'fa-solid fa-gift', Don::class)
            ->setPermission("ROLE_BANQUE");
        yield MenuItem::linkToCrud('envoie', 'fa-solid fa-less', Envoye::class)
            ->setPermission("ROLE_BANQUE");

    }
    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    public function configureCrud(): Crud
    {
        return parent::configureCrud()->showEntityActionsInlined();
    }
}
