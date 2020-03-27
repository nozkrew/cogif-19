<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => "Donnes un titre à ton gif"
            ))
            ->add('content', null, array(
                'label' => "L'URL de ton GIF"
            ))
            ->add('user', UserType::class)
            ->add('post', SubmitType::class, array(
                'label' => "Enregistrer et revenir à l'accueil"
            ))
            ->add('postAndRepost', SubmitType::class, array(
                'label' => "Enregistrer et ajouter un autre GIF"
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
