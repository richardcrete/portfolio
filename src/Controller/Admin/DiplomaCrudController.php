<?php

namespace App\Controller\Admin;

use App\Admin\TranslatableTextFilter;
use App\Admin\TranslationsField;
use App\Entity\Diploma;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DiplomaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Diploma::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Diploma')
            ->setEntityLabelInPlural('Diplomas')
            ->setSearchFields(['id', 'date', 'city'])
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(50);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield DateField::new('startDate')->setRequired(true);
        yield DateField::new('endDate')->setRequired(true);
        yield TextField::new('city')->setRequired(true);
        yield TranslationsField::new('translations')
            ->addTranslatableField(TextField::new('name')->setRequired(true))
            ->addTranslatableField(TextField::new('school')->setRequired(true));
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters;
//            ->add(TranslatableTextFilter::new('description'));
    }
}