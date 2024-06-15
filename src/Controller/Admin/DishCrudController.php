<?php

namespace App\Controller\Admin;

use App\Entity\Dish;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DishCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dish::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield AssociationField::new('category')->setFormTypeOption('multiple', false);
        yield NumberField::new('price')->setDecimalSeparator(',');
        yield TextEditorField::new('description');
        yield ImageField::new('photo')
            ->setBasePath($this->getParameter('uploads_base_path'))
            ->setUploadDir($this->getParameter('uploads_directory'))
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired($pageName !== Crud::PAGE_EDIT);
        yield PercentField::new('discount')
            ->setStoredAsFractional(false)
            ->setNumDecimals(0);
    }


}
