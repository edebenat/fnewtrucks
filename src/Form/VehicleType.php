<?php

namespace App\Form;

use App\Entity\Vehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model', TextType::class, [
                'label' => 'Modèle',
                'attr' => [
                    'placeholder' => 'Ford F-Max'
                ]
            ])
            ->add('type', TextType::class, [
                'label' => 'Type',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Tracteur'
                ]
            ])
            ->add('gears', TextType::class, [
                'label' => 'Essieux',
                'required' => false,
                'attr' => [
                    'placeholder' => '4x2'
                ]
            ])
            ->add('enginePower', TextType::class, [
                'label' => 'Puissance',
                'required' => false,
                'attr' => [
                    'placeholder' => '500 cv'
                ]
            ])
            ->add('state', TextType::class, [
                'label' => 'Neuf/Occasion',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Occasion'
                ]
            ])
            ->add('mileageFromOdometer', TextType::class, [
                'label' => 'Kilométrage',
                'required' => false,
                'attr' => [
                    'placeholder' => '55 000 kms'
                ]
            ])
            ->add('carac1', TextType::class, [
                'required' => false
            ])
            ->add('carac2', TextType::class, [
                'required' => false
            ])
            ->add('carac3', TextType::class, [
                'required' => false
            ])
            ->add('carac4', TextType::class, [
                'required' => false
            ])
            ->add('equipments', TextareaType::class, [
                'label' => 'Equipements',
                'required' => false,
                'attr' => [
                    'rows' => 10
                ]
            ])
            ->add('guarantee', TextType::class, [
                'label' => 'Garantie',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Garantie constructeur jusqu’au 00/00/0000'
                ]
            ])
            ->add('price', TextType::class, [
                'label' => 'Prix',
                'required' => false,
                'attr' => [
                    'placeholder' => '50 000 €'
                ]
            ])
            ->add('rental', TextType::class, [
                'label' => 'Loyer',
                'required' => false,
                'attr' => [
                    'placeholder' => '1 500 € / mois'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
