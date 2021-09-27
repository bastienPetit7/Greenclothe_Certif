<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'nom du produit', 
                'attr' => [

                    'placeholder' => 'entrer le nom du produit'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'déscription du produit', 
                'attr' => [

                    'placeholder' => 'décrire le produit'
                ]
            ])
            ->add('price', MoneyType::class, [
                'currency'=>"EUR",
                "divisor"=> 100,
                'label' => "Prix du Produit", 
                'attr'=>[
                    "placeholder" => "Entrer le prix du Produit"
                ]
            ])
            ->add('taille', ChoiceType::class, [
                'choices_list' => [
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL',
                ], 
                'multiple' => true, 
                'expanded' => true
            ])
            ->add('image_path_url', FileType::class)
            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
