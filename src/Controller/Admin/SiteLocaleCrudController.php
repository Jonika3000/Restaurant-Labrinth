<?php

namespace App\Controller\Admin;

use App\Entity\SiteLocale;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SiteLocaleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SiteLocale::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Site locale')
            ->setPageTitle(Crud::PAGE_NEW, 'Create site locale')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit site locale');
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
