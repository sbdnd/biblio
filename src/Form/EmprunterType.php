<?php

namespace App\Form;

use App\Entity\Adherent;
use App\Entity\Emprunter;
use App\Entity\Exemplaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EmprunterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePret', TextType::class, [
                'disabled'=>true
            ])
            ->add('dateRetourPrevue', DateTimeType::class, [
                'disabled'=>true
            ])
            ->add('dateRetourReelle', DateTimeType::class, [
                'label' => 'Date de retour'
            ])
            ->add('exemplaire', EntityType::class, [
                'class' => Exemplaire::class,
                'label' => 'Code exemplaire',
                'disabled'=> true
                ])
            ->add('adherent', EntityType::class, [
                'class' => Adherent::class,
                'disabled'=> true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunter::class,
        ]);
    }
}
