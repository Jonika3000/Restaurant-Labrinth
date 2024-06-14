<?php

namespace App\Controller\Admin\Translate;

use App\Entity\Translate\CategoryTranslate;
use Doctrine\ORM\EntityManagerInterface;
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

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof CategoryTranslate) {
            $event = $entityInstance->getCategory();
            $existingTranslation = $entityManager->getRepository(CategoryTranslate::class)
                ->findOneBy(['category' => $event]);

            if ($existingTranslation) {
                throw new \Exception('This category already has a translation.');
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
