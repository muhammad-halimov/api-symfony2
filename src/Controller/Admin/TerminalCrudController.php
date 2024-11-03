<?php

namespace App\Controller\Admin;

use App\Entity\Terminal;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            ->setEntityLabelInSingular('контент')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление контента')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение контента');
    }
}
