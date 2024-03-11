<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Trait\CreateReadDeleteTrait;
use App\Entity\Invitation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InvitationCrudController extends AbstractCrudController
{
    use CreateReadDeleteTrait;
    public static function getEntityFqcn(): string
    {
        return Invitation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('contact'),
            TextField::new('uuid')
                ->hideWhenCreating(),
            AssociationField::new('reader')
                ->hideWhenCreating()
        ];
    }

}
