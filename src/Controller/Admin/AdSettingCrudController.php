<?php

namespace App\Controller\Admin;

use App\Entity\AdSetting;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdSettingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AdSetting::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->hideOnForm();

        yield DateTimeField::new('beginning', 'Начало')
            ->setColumns(6);

        yield DateTimeField::new('ending', 'Конец')
            ->setColumns(6);

        yield IntegerField::new('showOrder', 'Порядок')
            ->setColumns(6);

        yield AssociationField::new('terminal', 'Терминал')
            ->setColumns(6)
            ->setFormTypeOptions(['placeholder' => 'Выберите терминал']) // Плейсхолдер для выпадающего списка
            ->setHelp('Выберите терминал'); // Помощь для выпадающего списка
    }
}
