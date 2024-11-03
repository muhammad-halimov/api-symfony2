<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichFileField;
use App\Entity\MemberVideo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MemberVideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MemberVideo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield VichFileField::new('videoFile', 'Видео')
            ->setHelp('
                <div class="mt-3">
                    <span class="badge badge-info">*.mp4</span>
                    <span class="badge badge-info">*.webm</span>
                </div>')
            ->onlyOnForms()
            ->setFormTypeOption('allow_delete', false)
            ->setRequired(false);

        yield TextField::new('title', 'Название');
    }
}
