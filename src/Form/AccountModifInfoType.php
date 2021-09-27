<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


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

            ->add('sex', ChoiceType::class, [
                
                'choices'=> [
                    'Monsieur' => 1,
                    'Madame' => 2
                ],
                
                
                'label_attr' => [
                    'class' => 'ml-4 form-control-sm'
                ],
                'expanded' => false, 
                
                
            ])

            ->add('dateDeNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'attr' => [
                    'placeholder' => 'Votre date de naissance',
                    
                ],
                'years' => range(1950, 2021)
                
                
            ])

            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe*', 
                'attr' => [
                    'placeholder' => 'mot de passe*',
                    'class' => 'form-control-sm'
                ]
                
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class, 
                'mapped' => false, 
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique', 
                'label' => 'Mon nouveau mot de passe', 
                'required' => false, 
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
