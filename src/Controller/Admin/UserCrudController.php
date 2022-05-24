<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $roles =
            [
                "Admin"=> 'ROLE_SUPER_ADMIN',
                "R5"=>"ROLE_R5",
                "R4"=> 'ROLE_R4'
            ];

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('username'),
            ChoiceField::new('roles')
                ->setChoices($roles)
                ->allowMultipleChoices()
                ->setRequired(false)
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

}
