<?php

namespace App\Form;

use App\Entity\Attestation;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AttestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('demande',TextType::class,array(

                'required' => false ,
            )
            )
            ->add('domaine',TextType::class,array(

                'required' => false ,
            )
            )
            ->add('date',DateType::class,array(

                'required' => false ,
            )
            )
           /* ->add('idservice',EntityType::class,[

                    'class' => Service::class,
                    'Choice_label'=>'Titre',


            ]

            )*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Attestation::class,
        ]);
    }
}