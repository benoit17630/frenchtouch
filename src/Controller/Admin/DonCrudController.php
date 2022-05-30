<?php

namespace App\Controller\Admin;

use App\Entity\Don;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Don::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            NumberField::new("cash"),
            NumberField::new("munition"),
            NumberField::new("marchandise"),
            NumberField::new("metal"),
            NumberField::new("diamant"),
            AssociationField::new("user", 'Menbre'),
            DateField::new("createdAt")->onlyOnIndex(),





        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)

            ->setPermission(Action::DELETE , 'ROLE_BANQUE')
            ->setPermission(Crud::PAGE_NEW, 'ROLE_BANQUE')

            ->setPermission(Crud::PAGE_DETAIL,'ROLE_BANQUE')
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE);

    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)->add("user");
    }


}
