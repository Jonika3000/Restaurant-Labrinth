<?php

namespace App\Controller\Admin\Translate;

use App\Entity\Translate\EventTranslate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventTranslateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventTranslate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Event translate')
            ->setPageTitle(Crud::PAGE_NEW, 'Create event translate')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit event translate');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextEditorField::new('text');
        yield AssociationField::new('locale')->setFormTypeOption('multiple', false);;
        yield AssociationField::new('event')->setFormTypeOption('multiple', false);;
    }
}
