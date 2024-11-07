<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichFileField;
use App\Controller\Admin\Field\VichImageField;
use App\Entity\StandbyMode;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StandbyModeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StandbyMode::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Режим ожидания')
            ->setEntityLabelInSingular('файл')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление файла')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение файла');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield VichFileField::new('targetFile', 'Файл')
            ->setHelp('
                <div class="mt-3">
                    <span class="badge badge-info">*.mp4</span>
                    <span class="badge badge-info">*.wmv</span>
                    <span class="badge badge-info">*.avi</span>
                </div>
            ')
            ->onlyOnForms()
            ->setFormTypeOption('allow_delete', false)
            ->setRequired(false)
            ->setColumns(8);

        yield VichFileField::new('target', 'Файл')
            ->hideOnForm()
            ->setColumns(8);

        yield BooleanField::new('turnOn', 'Показывать');

        yield DateTimeField::new('updatedAt', 'Обновлено')
            ->hideOnForm();
    }
}
