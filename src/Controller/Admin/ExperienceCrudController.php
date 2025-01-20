<?php

namespace App\Controller\Admin;

use App\Admin\TranslatableTextFilter;
use App\Admin\TranslationsField;
use App\Entity\Experience;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ExperienceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Experience::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Experience')
            ->setEntityLabelInPlural('Experiences')
            ->setSearchFields(['id', 'name', 'translations.description'])
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(50);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name')->setRequired(true);
        yield DateField::new('startDate')->setRequired(true)->hideOnIndex();
        yield DateField::new('endDate')->setRequired(false)->hideOnIndex();
        yield AssociationField::new('tools')->setRequired(true)->hideOnIndex();
        yield TranslationsField::new('translations')
            ->addTranslatableField(TextField::new('job')->setRequired(true))
            ->addTranslatableField(TextField::new('description')->setRequired(true))
            ->addTranslatableField(UrlField::new('link')->setRequired(true));
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters;
//            ->add(TranslatableTextFilter::new('description'));
    }
}