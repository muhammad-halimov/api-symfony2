<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichFileField;
use App\Entity\Updates;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UpdatesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Updates::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Обновления')
            ->setEntityLabelInSingular('контент')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление контента')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение контента');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield TextEditorField::new('description', 'Описание')
            ->setColumns(8);

        yield VichFileField::new('targetFile', 'Архив с обновлением')
            ->setHelp('
                <div class="mt-3">
                    <span class="badge badge-info">*.zip</span>
                    <span class="badge badge-info">*.rar</span>
                    <span class="badge badge-info">*.tar</span>
                </div>
            ')
            ->onlyOnForms()
            ->setFormTypeOption('allow_delete', false)
            ->setRequired(false)
            ->setColumns(8);

        yield TextField::new('version', 'Версия')
            ->setColumns(8)
            ->setRequired(true);

        yield ChoiceField::new('type', 'Тип')
            ->setColumns(8)
            ->setChoices([
                'Модифицированная версия' => 'modified',
                'Стабильная версия' => 'stable',
            ])
            ->setRequired(true);
    }
}
