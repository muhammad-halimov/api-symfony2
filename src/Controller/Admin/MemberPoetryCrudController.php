<?php

namespace App\Controller\Admin;

use App\Entity\MemberPoetry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MemberPoetryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MemberPoetry::class;
    }
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Название')
            ->setColumns(8);
        yield TextField::new('description', 'Описание')
            ->setColumns(8);
        yield TextEditorField::new('text', 'Текст')
            ->setColumns(8);
    }
}
