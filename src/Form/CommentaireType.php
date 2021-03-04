<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\Forum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message')
            ->add('idpublication', EntityType::class, [
                'class' => Forum::class,
                'choice_label' => 'titre',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
