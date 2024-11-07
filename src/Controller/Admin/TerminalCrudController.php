<?php

namespace App\Controller\Admin;

use App\Entity\Terminal;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TerminalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Terminal::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Терминалы')
            ->setEntityLabelInSingular('терминал')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление терминала')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение терминала');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield TextField::new('title', 'Название')
            ->setColumns(5);

        yield IntegerField::new('standbyModeLatency', 'Задержка перехода в режим ожидания')
            ->setRequired(true)
            ->setColumns(5)
            ->setHelp('В секундах');

        yield IntegerField::new('nextAdLatency', 'Время смены рекламы')
            ->setRequired(true)
            ->setColumns(5)
            ->setHelp('В секундах');

        yield AssociationField::new('updates', 'Обновления')
            ->setColumns(5)
            ->setFormTypeOptions(['placeholder' => 'Выберите обновление']) // Плейсхолдер для выпадающего списка
            ->setHelp('Выберите доступное обновление'); // Помощь для выпадающего списка
    }
}
