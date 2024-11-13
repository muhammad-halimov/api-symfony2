<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichFileField;
use App\Entity\Ad;
use App\Entity\Updates;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class AdCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ad::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Реклама')
            ->setEntityLabelInSingular('рекламу')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление рекламы')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение рекламы');
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Ad $entityInstance */
        if ($entityInstance->getOptions()->isEmpty()) {
            parent::deleteEntity($entityManager, $entityInstance);
            return;
        }

        $this->addFlash('warning', 'Нельзя удалить рекламу, к нему привязаны опции.');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield CollectionField::new('options', 'Настройки')
            ->onlyOnForms()
            ->useEntryCrudForm(AdSettingCrudController::class)
            ->setColumns(8);

        yield TextEditorField::new('optionsToString', 'Информация')
            ->hideOnForm()
            ->setColumns(8);

        yield VichFileField::new('imageFile', 'Файл')
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

        yield VichFileField::new('image', 'Файл')
            ->hideOnForm()
            ->setColumns(8);

        yield BooleanField::new('turnOn', 'Показывать');

        yield DateTimeField::new('updatedAt', 'Обновлено')
            ->hideOnForm();
    }
}
