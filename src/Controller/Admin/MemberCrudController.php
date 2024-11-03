<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichImageField;
use App\Entity\Member;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Участники')
            ->setEntityLabelInSingular('участника')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление участника')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение участника');
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Главная');
        yield ChoiceField::new('type', 'Тип')
            ->setChoices(
                [
                    'Герои Российской Федерации' => 'Heroes',
                    'Харовчане-участники СВО' => 'Harovchane'
                ]);
        yield TextField::new('surname', 'Фамилия');
        yield TextField::new('name', 'Имя');
        yield TextField::new('patronymic', 'Отчество');
        yield TextEditorField::new('biography', 'Биография');
        yield CollectionField::new('images', 'Изображения')
            ->onlyOnForms()
            ->setRequired(false)
            ->showEntryLabel(false)
            ->setCustomOption('prototype_name', '__images_deeper_map__')
            ->useEntryCrudForm(MemberImagesCrudController::class);
        yield DateField::new('startAt', 'Дата рождения');
        yield DateField::new('endAt', 'Дата Смерти');
        yield FormField::addTab('Аудио');
        yield CollectionField::new('audios', 'Аудио')
            ->onlyOnForms()
            ->setRequired(false)
            ->showEntryLabel(false)
            ->setCustomOption('prototype_name', '__images_deeper_map__')
            ->useEntryCrudForm(MemberAudioCrudController::class);
        yield FormField::addTab('Видео');
        yield CollectionField::new('videos', 'Видео')
            ->onlyOnForms()
            ->setRequired(false)
            ->showEntryLabel(false)
            ->setCustomOption('prototype_name', '__images_deeper_map__')
            ->useEntryCrudForm(MemberVideoCrudController::class);
        yield FormField::addTab('Поэзия');
        yield CollectionField::new('poetry', 'Поэзия')
            ->onlyOnForms()
            ->setRequired(false)
            ->showEntryLabel(false)
            ->setCustomOption('prototype_name', '__images_deeper_map__')
            ->useEntryCrudForm(MemberPoetryCrudController::class)
            ->addJsFiles(Asset::fromEasyAdminAssetPackage('field-text-editor.js')->onlyOnForms())
            ->addCssFiles(Asset::fromEasyAdminAssetPackage('field-text-editor.css')->onlyOnForms());

        yield DateTimeField::new('updatedAt', 'Обновлено')
            ->hideOnForm();
    }
}
