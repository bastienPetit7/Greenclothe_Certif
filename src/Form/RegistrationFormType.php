<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom', TextType::class, [
                'label' => 'Votre nom',
                'required' => false,
                'attr'=> [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])

            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom',
                'required' => false,
                'attr'=> [
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])

            ->add('telephone', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'required' => false,
                'attr'=> [
                    'placeholder' => 'Entrez votre numéro de téléphone'
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email',
                'required' => false,
                'attr'=> [
                    'placeholder' => 'Entrez votre adresse email'
                ]
            ])
            
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Votre mot de passe',

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password', 
                    'placeholder' => 'Entrez votre mot de passe'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
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
