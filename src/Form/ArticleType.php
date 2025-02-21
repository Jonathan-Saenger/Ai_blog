<?php

namespace App\Form;

use App\Entity\Article;
use Ehyiah\QuillJsBundle\DTO\Fields\BlockField\AlignField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ehyiah\QuillJsBundle\Form\QuillType;
use Ehyiah\QuillJsBundle\DTO\Fields\InlineField\BoldField;
use Ehyiah\QuillJsBundle\DTO\Fields\InlineField\ItalicField;
use Ehyiah\QuillJsBundle\DTO\Fields\InlineField\UnderlineField;
use Ehyiah\QuillJsBundle\DTO\Fields\BlockField\HeaderField;
use Ehyiah\QuillJsBundle\DTO\QuillGroup;

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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class, // Associe ce formulaire à l'entité Article
        ]);
    }
}