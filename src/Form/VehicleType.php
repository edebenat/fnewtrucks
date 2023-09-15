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
                'label' => 'Modèle'
            ])
            ->add('type', TextType::class, [
                'label' => 'Type',
                'required' => false
            ])
            ->add('gears', TextType::class, [
                'label' => 'Essieux',
                'required' => false
            ])
            ->add('enginePower', TextType::class, [
                'label' => 'Puissance',
                'required' => false
            ])
            ->add('state', TextType::class, [
                'label' => 'Neuf/Occasion',
                'required' => false
            ])
            ->add('mileageFromOdometer', TextType::class, [
                'label' => 'Kilométrage',
                'required' => false
            ])
            ->add('equipments', TextareaType::class, [
                'label' => 'Equipements',
                'required' => false
            ])
            ->add('guarantee', TextType::class, [
                'label' => 'Garantie',
                'required' => false
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
