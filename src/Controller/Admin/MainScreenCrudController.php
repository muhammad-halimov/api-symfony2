<?php

namespace App\Controller\Admin;

use App\Entity\MainScreen;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MainScreenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MainScreen::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Главный экран')
            ->setEntityLabelInSingular('картинку')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление картинок')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение картинок');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER);
        $actions->remove(Crud::PAGE_NEW, Action::SAVE_AND_RETURN);
        $actions->remove(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN);
        $actions->add(Crud::PAGE_NEW, Action::SAVE_AND_CONTINUE);

        return parent::configureActions($actions);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titleSvo', 'Название кнопки 1');
        yield TextField::new('titleHeroes', 'Название кнопки 2');
        yield TextField::new('titleMembers', 'Название кнопки 3');
    }
}
