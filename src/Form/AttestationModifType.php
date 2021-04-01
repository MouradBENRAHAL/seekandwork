<?php

namespace App\Form;

use App\Entity\Attestation;
use App\Entity\Entreprise;
use App\Entity\Service;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttestationModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('domaine',TextType::class)
            ->add('email',EmailType::class)
            ->add('File',FileType::class)

            /*
             * ->add('datepublication',DateType::class,[
                'label'=>'Publié le'
            ])
            */

            ->add( 'idservice', EntityType::class,[
                'class' => Service::class,
                'choice_label' => 'id',

            ])


            ->add('identreprise',EntityType::class,[
                'class'=>Entreprise::class,
                'choice_label'=>'nom',
                'label'=>'nom entreprise',
            ])

            ->add('Modifier',SubmitType::class)


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
            'required' => false ,
        ]);
    }
}
