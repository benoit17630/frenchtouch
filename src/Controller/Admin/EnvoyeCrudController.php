<?php

namespace App\Controller\Admin;

use App\Entity\Envoye;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class EnvoyeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Envoye::class;
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
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)->add('user');
    }

}
