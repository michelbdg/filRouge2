<?php

namespace App\Form;

use App\Entity\Transporteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChoisirTransporteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('transporteur', EntityType::class, [
            'label' => 'Liste des transporteurs disponible',
            'required' => true,
            'class' => Transporteur::class, 
            'multiple' => false,
            'expanded' => true
            
        ])
        ->add('submit', SubmitType::class,[ 
            'label' => 'Valider',
            'attr' => [
            'class' => 'btn btn-primary btn-block'
            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
