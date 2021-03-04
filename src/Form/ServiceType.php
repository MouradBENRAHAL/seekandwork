<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rdv', DateTimeType::class,array(

                'required' => false ,
            )
            )
            ->add('email',EmailType::class,array(

                'required' => false ,
            )
            )
            ->add('rapport',FileType::class,array(

                'required' => false ,
                    'data_class' => null,
            )
            )
            ->add( 'idUser', EntityType::class,array(
                'class' => User::class,
                'choice_label' => 'id',
            )
            )
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
