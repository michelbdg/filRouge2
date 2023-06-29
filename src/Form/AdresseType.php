<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class,[
                'label' => 'Libellé'
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('nom', TextType::class,[
                'label' => 'Nom'
            ])
            ->add('textAdresse', TextType::class,[
                'label' => 'Adresse'
            ])
            ->add('phone', TelType::class,[
                'label' => 'Téléphone'
            ])
            ->add('cp', TextType::class,[
                'label' => 'Code Postal'
            ])
            ->add('ville', TextType::class,[
                'label' => 'Ville'
            ])
            ->add('pays', TextType::class,[
                'label' => 'Pays'
            ])
            ->add('societe', TextType::class,[
                'label' => 'Société'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
