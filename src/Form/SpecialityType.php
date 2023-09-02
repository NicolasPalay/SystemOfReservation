<?php

namespace App\Form;

use App\Entity\Speciality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class SpecialityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameSpeciality')
            ->add('duration')
            ->add('content')
            ->add('rate',MoneyType::class,[
                'label'=>'Tarif',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Tarif',
                    'class' => 'form-control'
                ],
                'divisor' => 100,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un tarif',
                    ]),
                    new Positive([
                        'message' => 'Le tarif doit être positif'
                    ])
                ]
    ])
            ->add('picture', FileType::class, [
                'multiple' => false,
                'label' => 'Ajouter une photo',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => 'image/jpeg, image/png, image/gif',
                    'onchange' => "previewPictures(this)"
                ],
                'constraints' => [
                    new All([
                        new Image([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                            ],
                            'mimeTypesMessage' => 'Veuillez sélectionner une image au format jpg, jpeg, png ou gif',
                            'maxSizeMessage' => 'Veuillez sélectionner une image de 2Mo maximum',
                        ])
                    ])
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Speciality::class,
        ]);
    }
}
