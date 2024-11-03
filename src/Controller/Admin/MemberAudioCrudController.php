<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichFileField;
use App\Entity\MemberAudio;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MemberAudioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MemberAudio::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield VichFileField::new('audioFile', 'Аудио')
            ->setHelp('
                <div class="mt-3">
                    <span class="badge badge-info">*.wav</span>
                    <span class="badge badge-info">*.mp3</span>
                    <span class="badge badge-info">*.mpeg</span>
                </div>
            ')
            ->onlyOnForms()
            ->setFormTypeOption('allow_delete', false)
            ->setRequired(false);

        yield TextField::new('title', 'Название');
    }
}
