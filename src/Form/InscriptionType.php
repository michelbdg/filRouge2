<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email'            
                ])
            ->add('password', RepeatedType::class,[
                'label' => 'Mot de passe',
                'required' => true
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Prénom',
                'constraints' => new Length(2,2,5),
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom',
                'constraints' => new Length(2,2,5)
            ])
            ->add('phone', TelType::class,[
                'label' => 'Téléphone',
            ])
            ->add('birthday', DateType::class,[
                'label' => 'Date de naissance'
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
