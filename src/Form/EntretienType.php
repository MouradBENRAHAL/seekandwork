<?php

namespace App\Form;

use App\Entity\Embauche;
use App\Entity\Entretien;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntretienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('cv' , FileType::class ,[
                'label'=>'Choississez une image',
                'attr' => ['class' => 'form-control']
            ])
            ->add('title')
            ->add('begin', DateTimeType::class,[
                'date_widget' => 'single_text'
            ])
            ->add('end', DateTimeType::class ,[
                'date_widget'=> 'single_text'
            ])
            ->add('idembauche',EntityType::class, [

                 'class' => Embauche::class,

                'choice_label' => 'titre',

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entretien::class,
        ]);
    }
}
