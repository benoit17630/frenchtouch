<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class StockCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stock::class;
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


        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->setPermission(Action::NEW, "ROLE_BANQUE")
            ->setPermission(Action::DELETE, "ROLE_R5")
            ->setPermission(Action::BATCH_DELETE, "ROLE_R5")
            ->setPermission(Action::EDIT, "ROLE_BANQUE");
    }
}
