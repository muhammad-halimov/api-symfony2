<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichImageField;
use App\Entity\MemberImages;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MemberImagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MemberImages::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield VichImageField::new('imageFile', 'Изображение')
            ->onlyOnForms()
            ->setFormTypeOption('allow_delete', false)
            ->setRequired(false)
            ->setColumns(8);
    }
}
