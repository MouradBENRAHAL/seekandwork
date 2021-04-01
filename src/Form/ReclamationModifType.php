<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Service;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description',TextareaType::class)


            ->add('iduser',EntityType::class,[
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('idservice',EntityType::class,[
                'class' => Service::class,
                'choice_label' => 'id',
            ])

            ->add('Modifier', SubmitType::class);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
            'required' => false ,
        ]);
    }
}
