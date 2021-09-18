<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountModifInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom*'
                ]
            ])
            ->add('nom',  TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom*'
                ]
            ])
            ->add('email', EmailType::class ,[
                'disabled'=> true
            ])
            ->add('old_password', PasswordType::class, [
                
                'label' => 'Mot de passe',
                'mapped' => false, 
                'attr' => [
                    'placeholder' => 'mot de passe',
                    'class' => 'form-control-sm'
                ]
                
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class, 
                'mapped' => false, 
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique', 
                'label' => 'Mon nouveau mot de passe', 
                'required' => true, 
                'first_options' => [
                    'label' => 'Nouveau mot de passe *',
                    'attr' => [
                        
                        'class' => 'form-control-sm'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer le nouveau mot de passe *',
                    'attr' => [
                        
                        'class' => 'form-control-sm'
                    ]
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
