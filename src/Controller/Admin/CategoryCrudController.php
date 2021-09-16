<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
         

        return [
            
            TextField::new('name'),
            TextareaField::new('description'),
            ImageField::new('image_path_url')
                ->setBasePath('assets/ressources/img/uploads/category/')
                ->setUploadDir('public/assets/ressources/img/uploads/category')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            
        ];
    }
    
}
