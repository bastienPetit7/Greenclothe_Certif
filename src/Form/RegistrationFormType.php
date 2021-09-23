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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                    'placeholder' => false
                ]
            ])

            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom',
                'required' => false,
                'attr'=> [
                    'placeholder' => false    
                ]
            ])

            ->add('telephone', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'required' => false,
                'attr'=> [
                    'placeholder' => false
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email',
                'required' => false,
                'attr'=> [
                    'placeholder' => false           
                ]
            ])

            ->add('sex', ChoiceType::class, [
                'label' => false,

                'choices'=> [
                    'Homme' => '1',
                    'Femme' => '2'
                ],
                'attr' => [
                    'class' => 'd-flex'
                ],
                'label_attr' => [
                    'class' => 'ml-1 mr-4 mt-2'
                ],
               
                'expanded' => true
                
            ])
            
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Votre mot de passe',

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password', 
                    'placeholder' => false          
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Veuillez accepter les CGUV',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les CGUV',
                    ]),
                ],
                'label_attr' => [
                    'class' => 'ml-1  mt-2'
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
