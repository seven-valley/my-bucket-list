<?php

namespace App\Form;

use App\Entity\Wish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,[
                'label'=>'Votre jolie titre',
                'attr' =>
                [

                    'placeholder'=>'Votre Titre'
                ]
            ])
            ->add('description')
            ->add('author')
            ->add('categ',null,[
                'choice_label'=>'name',
                'placeholder' => 'PAS DE CATEG'
            ])
            //->add('isPublished')
            //->add('dateCreated')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
