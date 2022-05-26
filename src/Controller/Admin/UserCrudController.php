<?php

namespace App\Controller\Admin;

use App\Entity\User;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\LocaleField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
                "Admin" => 'ROLE_SUPER_ADMIN',
                "R5" => "ROLE_R5",
                "R4" => 'ROLE_R4',
                "banque" => 'ROLE_BANQUE'
            ];

        return [


            TextField::new('username', "Pseudo"),

            NumberField::new("taxe"),

            LocaleField::new("locale"),

            TextareaField::new("commentaire")
                ->setRequired(false)
                ->setPermission('ROLE_R5'),
            BooleanField::new("isBanque")
                ->setPermission('ROLE_R5'),

            ChoiceField::new('roles')
                ->setChoices($roles)
                ->allowMultipleChoices()
                ->setRequired(false)
                ->setPermission('ROLE_BANQUE'),

            AvatarField::new("avatar" , "Avatar")
                ->formatValue(static function($value, ?User $user)
                {
                    return $user?->getAvatarUrl();
                })
                ->hideOnForm(),


            ImageField::new('avatar')
                ->setBasePath("uploads/avatars")
                ->setUploadDir("public/uploads/avatars")
                ->setUploadedFileNamePattern("[slug]-[timestamp].[extension]")
                ->onlyOnForms()


        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->setPermission(Action::DELETE, 'ROLE_BANQUE')
            ->setPermission(Action::BATCH_DELETE, "ROLE_R5");
    }

    public function createIndexQueryBuilder(
        SearchDto        $searchDto,
        EntityDto        $entityDto,
        FieldCollection  $fields,
        FilterCollection $filters): QueryBuilder
    {
        $menbre = $this->getUser()->getUserIdentifier();

        if ($this->isGranted('ROLE_R5')) {
            return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        } else {
            return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
                ->andWhere('entity.username = :user')
                ->setParameter("user", $menbre);
        }

    }


}
