<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichImageField;
use App\Entity\Category;
use App\Entity\Updates;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Категории')
            ->setEntityLabelInSingular('катергорию')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление категории')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение категории');
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Category $entityInstance */
        if ($entityInstance->getTenant()->isEmpty()) {
            parent::deleteEntity($entityManager, $entityInstance);
            return;
        }

        $this->addFlash('warning', 'Нельзя удалить категорию, к нему привязаны арендаторы.');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield TextField::new('title', 'Название')
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

        yield CollectionField::new('tenant', 'Арендаторы')
            ->onlyOnIndex()
            ->useEntryCrudForm(TenantCrudController::class);

        yield DateTimeField::new('updatedAt', 'Обновлено')
            ->hideOnForm();
    }
}
