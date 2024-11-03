<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\VichGalleryField;
use App\Entity\History;
use App\Repository\HistoryRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return History::class;
    }

    public function __construct(private readonly HistoryRepository $historyRepository)
    {
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('История СВО / Харовск и СВО')
            ->setEntityLabelInSingular('контент')
            ->setPageTitle(Crud::PAGE_NEW, 'Добавление контента')
            ->setPageTitle(Crud::PAGE_EDIT, 'Изменение контента');
    }

    public function configureActions(Actions $actions): Actions
    {
        $configureActions = parent::configureActions($actions)
            ->disable(Action::SAVE_AND_ADD_ANOTHER);

        if ($this->historyRepository->count([]) > 1) {
            $configureActions
                ->disable(Action::NEW);
        }

        return $configureActions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('type', 'Тип')
            ->setChoices(
                [
                    'История СВО' => 'History',
                    'Харовск и СВО' => 'Harovsk'
                ]);
        yield CollectionField::new('images', 'Изображения')
            ->onlyOnForms()
            ->setRequired(false)
            ->showEntryLabel(false)
            ->setCustomOption('prototype_name', '__images_deeper_map__')
            ->useEntryCrudForm(HistoryImagesCrudController::class);

        yield VichGalleryField::new('images.image', 'Изображения')
            ->hideOnForm();
        yield TextEditorField::new('description', 'Описание');
    }
}
