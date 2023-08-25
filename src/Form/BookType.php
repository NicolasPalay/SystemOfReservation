<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleBook',TextType::class,[
                'label'=>'Titre de l\'article'
            ])
            ->add('content',TextareaType::class,[
                'label'=>'Contenu de l\'article'
            ])
            ->add('pictures',FileType::class,[
                    'multiple'=>true,
                    'label'=>'Ajouter des photos',
                    'mapped'=>false,
                'required' => false,
                'attr' => [
                    'accept' => 'image/jpeg, image/png, image/gif',
                'onchange' => "previewPictures(this)"
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
