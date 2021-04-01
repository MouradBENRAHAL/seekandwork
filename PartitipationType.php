<?php

namespace App\Form;

use App\Entity\Partitipation;
use App\Entity\Specialisation;
use App\Entity\Event;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Gregwar\CaptchaBundle\Type\CaptchaType;



class PartitipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('captcha', CaptchaType::class);
        $builder
            ->add('nom')
            ->add('email',EmailType::class)
            ->add('idspecialisation',EntityType::class,['class'=>Specialisation::class,'choice_label'=>'text'])
            //->add('email',EntityType::class,['class'=>User::class,'choice_label'=>'email'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partitipation::class,
            'required' => false,

        ]);


    }






}
