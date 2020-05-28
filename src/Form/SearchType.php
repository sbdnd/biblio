<?php
namespace App\Form;

use App\Entity\Genre;
use App\Entity\Auteur;
use App\Search\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Tapez un titre'
                ]
            ])
            ->add('auteurs', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Auteur::class,
                'placeholder' => 'Sélectionnez un auteur'
                // 'expanded' => true,
                //'multiple' => true
            ])
            ->add('genre', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Genre::class,
                'placeholder' => 'Choisir une catégorie'
                // 'expanded' => true,
                // 'multiple' => true
            ])
     
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>SearchData::class,
            'method'=>'GET',
            'csrf_protection'=>false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}