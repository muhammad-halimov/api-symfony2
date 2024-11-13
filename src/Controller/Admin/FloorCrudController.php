<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichImageField;
use App\Entity\Floor;
use App\Entity\Updates;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class FloorCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var Floor $entityInstance */
        if ($entityInstance->getTenant()->isEmpty()) {
            parent::deleteEntity($entityManager, $entityInstance);
            return;
        }

        $this->addFlash('warning', 'Нельзя удалить этаж, к нему привязаны арендаторы.');
    }

    public function configureActions(Actions $actions): Actions
    {
        $floorCount = $this->entityManager->getRepository(Floor::class)->count([]);

        if ($floorCount >= 4) {
            $actions->remove(Crud::PAGE_INDEX, Action::NEW);
        }

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield IntegerField::new('floor', 'Этаж')
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

        yield DateTimeField::new('updatedAt', 'Обновлено')
            ->hideOnForm();
    }
}
