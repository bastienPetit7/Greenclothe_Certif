<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Je récupére le user passé dans mon tableau d'option via le OrderController
         $user = $options['user']; 

        $builder
            ->add('addresses', EntityType::class, [
                'label' => false,
               
                'required' => true, 
                'class' => Address::class, 
                'choices' => $user->getAddresses(),
                'multiple' => false, 
                'expanded' => true,

            ])
            ->add('carrier', EntityType::class, [
                'label' => 'Choisissez votre livreur',
                'required' => true, 
                'class' => Carrier::class, 
                'multiple' => false, 
                'expanded' => true,

            ])
            // ->add('submit', SubmitType::class, [
            //     'label' => 'Valider ma commande', 
            //     'attr' => [
            //         'class' => 'btn btn-info btn-sm'
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array()
        ]);
    }
}
