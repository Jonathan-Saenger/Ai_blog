<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ehyiah\QuillJsBundle\Form\QuillType;
use Ehyiah\QuillJsBundle\DTO\QuillGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title') // Champ pour le titre de l'article
            ->add('content', QuillType::class, [
                'quill_extra_options' => [
                    'height' => '300px',  // Définit la hauteur de l'éditeur
                    'theme' => 'snow',   // Utilise le thème "snow"
                    'placeholder' => 'Commencez à écrire...', // Texte d'indication
                ],
                'quill_options' => [QuillGroup::buildWithAllFields()]
            ])
            ->add('category', EntityType::class, [
                'class' => ArticleCategory::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une catégorie',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class, // Associe ce formulaire à l'entité Article
        ]);
    }
}