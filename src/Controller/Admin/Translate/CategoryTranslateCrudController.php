<?php

namespace App\Controller\Admin\Translate;

use App\Entity\Translate\CategoryTranslate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryTranslateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoryTranslate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Category translate')
            ->setPageTitle(Crud::PAGE_NEW, 'Create category translate')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit category translate');
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextareaField::new('description');
        yield AssociationField::new('locale')->setFormTypeOption('multiple', false);;
        yield AssociationField::new('category')->setFormTypeOption('multiple', false);;
    }
}
