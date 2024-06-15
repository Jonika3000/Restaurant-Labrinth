<?php

namespace App\Controller\Admin;

use App\Entity\Table;
use App\Entity\TableReserved;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TableReservedCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TableReserved::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('phoneNumber');
        yield DateTimeField::new('date');
        yield NumberField::new('numberofPeople');
        yield AssociationField::new('tableToReserve')->setFormTypeOption('multiple', false);
    }
}
