<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichImageField;
use App\Entity\Tenant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TenantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tenant::class;
    }

    public function __construct(){}

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Арендаторы')
            ->setEntityLabelInSingular('арендатора')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление арендатора')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение арендатора');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield TextField::new('title', 'Название')
            ->setRequired(true)
            ->setColumns(2);

        yield AssociationField::new('category', 'Категории')
            ->setColumns(2);

        yield AssociationField::new('floor', 'Этажи')
            ->setColumns(2);

        yield TextField::new('phone', 'Телефон')
            ->setColumns(2)
            ->onlyOnForms();

        yield TextEditorField::new('description', 'Описание')
            ->setRequired(true)
            ->setColumns(8)
            ->onlyOnForms();

        yield VichImageField::new('imageFile', 'Логотип')
            ->setHelp('
                <div class="mt-3">
                    <span class="badge badge-info">*.jpg</span>
                    <span class="badge badge-info">*.jpeg</span>
                    <span class="badge badge-info">*.png</span>
                </div>
            ')
            ->onlyOnForms()
            ->setFormTypeOption('allow_delete', false)
            ->setRequired(false)
            ->setColumns(8);

        yield VichImageField::new('image', 'Логотип')
            ->hideOnForm()
            ->setColumns(8);

        yield CollectionField::new('photos', 'Фотографии')
            ->onlyOnForms()
            ->useEntryCrudForm(MemberImagesCrudController::class);

        yield DateTimeField::new('updatedAt', 'Обновлено')
            ->hideOnForm();
    }
}
