<?php

namespace App\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use Symfony\Component\Validator\Constraints\Valid;

class TranslationsConfigurator implements FieldConfiguratorInterface
{
    public function __construct(private iterable $fieldConfigurators)
    {
    }

    public function supports(FieldDto $field, EntityDto $entityDto): bool
    {
        return $field->getFieldFqcn() === TranslationsField::class;
    }

    public function configure(FieldDto $field, EntityDto $entityDto, AdminContext $context): void
    {
        $formTypeOptionsFields = [];

        $fieldsCollection = FieldCollection::new(
            (array)$field->getCustomOption(TranslationsField::OPTION_FIELDS_CONFIG)
        );

        foreach ($fieldsCollection as $dto) {
            /** @var FieldDto $dto */

            foreach ($this->fieldConfigurators as $configurator) {
                if (!$configurator->supports($dto, $entityDto)) {
                    continue;
                }

                $configurator->configure($dto, $entityDto, $context);
            }

            foreach ($dto->getFormThemes() as $formThemePath) {
                $context?->getCrud()?->addFormTheme($formThemePath);
            }

            // add translatable fields assets
            $context->getAssets()->mergeWith($dto->getAssets());

            $dto->setFormTypeOption('field_type', $dto->getFormType());
            $formTypeOptionsFields[$dto->getProperty()] = $dto->getFormTypeOptions();
        }

        $field->setFormTypeOptions([
            'ea_fields' => $fieldsCollection,
            'fields' => $formTypeOptionsFields,
            'constraints' => [
                new Valid(),
            ],
        ]);
    }
}