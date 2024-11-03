<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichImageField;
use App\Entity\Floor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FloorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Floor::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Этажи')
            ->setEntityLabelInSingular('этаж')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление этажа')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение этажа');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield TextField::new('floor', 'Этаж')
            ->setRequired(true)
            ->setColumns(5);

        yield VichImageField::new('imageFile', 'Логотип')
            ->setHelp('
                <div class="mt-3">
                    <span class="badge badge-info">*.jpg</span>
                    <span class="badge badge-info">*.jpeg</span>
                    <span class="badge badge-info">*.png</span>
                    <span class="badge badge-info">*.webp</span>
                </div>
            ')
            ->onlyOnForms()
            ->setFormTypeOption('allow_delete', false)
            ->setRequired(false)
            ->setColumns(8);

        yield VichImageField::new('image', 'Картинка')
            ->hideOnForm()
            ->setColumns(8);
    }
}
