<?php

namespace App\Form;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Entity\Exemplaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExemplaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeExemplaire')
            ->add('dateAcquisition')
            ->add('dispo')
            ->add('livre', LivreType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exemplaire::class,
        ]);
    }
}
