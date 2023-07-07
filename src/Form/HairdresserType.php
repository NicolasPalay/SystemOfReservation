<?php

namespace App\Form;

use App\Entity\Hairdresser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HairdresserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('User')
            ->add('specialities')
            ->add('picture',FileType::class,[
                'multiple'=>false,
                'label'=>'Ajouter une photo',
                'mapped'=>false,
                'attr' => [
                    'accept' => 'image/jpeg, image/png, image/gif',
                    'onchange' => "previewPictures(this)"
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hairdresser::class,
        ]);
    }
}
