<?php

namespace App\Controller\Admin;

use App\Entity\Don;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
            AssociationField::new("user"),





        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->remove(Crud::PAGE_INDEX,"delete")

            ->setPermission(Crud::PAGE_NEW, 'ROLE_R5')
            ->setPermission(Crud::PAGE_EDIT, 'ROLE_R5')
            ->setPermission(Crud::PAGE_DETAIL,'ROLE_R5');




    }

}
