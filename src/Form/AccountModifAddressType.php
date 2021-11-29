<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AccountModifAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ChoiceType::class, [
                'label' => "Quel nom souhaitez-vous donner à votre adresse? ",
                'choices' => [
                    'adresse de facturation' => 'Adresse de facturation', 
                    'adresse de livraison' => 'Adresse de livraison'
                ], 
                'attr' => [
                    // 'placeholder' => 'Nommez votre adresse'
                ],
                'expanded' => false, 
            ])
            ->add('firstname', TextType::class, [
                'label' => "Votre prénom * ",
                'attr' => [
                    // 'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Votre nom de famille * ",
                'attr' => [
                    // 'placeholder' => 'Entrez votre nom de famille'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => "Nom de votre société? ",
                'attr' => [
                    // 'placeholder' => '(facultatif) Nommez votre société'
                ], 
                'required' => false
            ])
            ->add('address', TextType::class, [
                'label' => "Votre adresse ",
                'attr' => [
                    'placeholder' => '48 rue Rivoly...'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => "Votre code postal ",
                'attr' => [
                    // 'placeholder' => 'Entrez votre code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => "Votre ville ",
                'attr' => [
                    // 'placeholder' => 'Entrez votre ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => "Votre pays",
                'attr' => [
                    // 'placeholder' => 'Entrer votre pays'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => "Votre numéro de téléphone ",
                'attr' => [
                    // 'placeholder' => 'Entrez votre numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider', 
                'attr' => [
                    'class' => 'btn-warning'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
