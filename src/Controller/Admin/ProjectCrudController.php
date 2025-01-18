<?php

namespace App\Controller\Admin;

use App\Admin\TranslatableTextFilter;
use App\Admin\TranslationsField;
use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Project')
            ->setEntityLabelInPlural('Projects')
            ->setSearchFields(['id', 'name', 'image', 'translations.description'])
            ->showEntityActionsInlined()
            ->setPaginatorPageSize(50);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name')->setRequired(true);
        yield DateField::new('startDate')->setRequired(true)->hideOnIndex();
        yield DateField::new('endDate')->setRequired(false)->hideOnIndex();
        yield ImageField::new('image')->setRequired(true)
            ->setFileConstraints(new Image(mimeTypes: ['image/jpg', 'image/jpeg', 'image/png']))
            ->setBasePath('/images/')
            ->setUploadedFileNamePattern(fn(UploadedFile $file): string => sprintf('%s.%s', uniqid(), $file->guessExtension()))
            ->setUploadDir('public/images');
        yield AssociationField::new('tools')->setRequired(true)->hideOnIndex();
        yield UrlField::new('githubLink')->setRequired(false)->hideOnIndex();
        yield TranslationsField::new('translations')
            ->addTranslatableField(TextField::new('description')->setRequired(true))
            ->addTranslatableField(UrlField::new('link')->setRequired(true));
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters;
//            ->add(TranslatableTextFilter::new('description'));
    }
}