<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Specialisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text')
            ->add('date')
            ->add('idevent',EntityType::class,['class'=>Event::class,'choice_label'=>'titre' ])
           // ->add('idpartitipation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialisation::class,
        ]);
    }
}
