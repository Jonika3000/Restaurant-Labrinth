<?php

namespace App\Controller\Admin\Translate;

use App\Entity\Translate\DishTranslate;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DishTranslateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DishTranslate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Dish translate')
            ->setPageTitle(Crud::PAGE_NEW, 'Create dish translate')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit dish translate');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextareaField::new('description');
        yield AssociationField::new('locale')->setFormTypeOption('multiple', false);;
        yield AssociationField::new('dish')->setFormTypeOption('multiple', false);;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof DishTranslate) {
            $event = $entityInstance->getDish();
            $existingTranslation = $entityManager->getRepository(DishTranslate::class)
                ->findOneBy(['dish' => $event]);

            if ($existingTranslation) {
                throw new \Exception('This dish already has a translation.');
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
