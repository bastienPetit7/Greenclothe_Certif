<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           TextField::new('name'), 
           SlugField::new('slug')->setTargetFieldName('name'),
           ImageField::new('image')
                ->setBasePath('assets/ressources/img/uploads/products')
                ->setUploadDir('public/assets/ressources/img/uploads/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false), 
            TextField::new('subtitle'),
            TextareaField::new('description'), 
            BooleanField::new('isBest'), 
            ChoiceField::new('taille')->setChoices(['S' => 's',
            'M' => 'm',
            'L' => 'l',
            'XL' => 'xl',
            'XXL' => 'xxl'])->allowMultipleChoices(),
            
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('category')
           
        ];
    }
    
}
