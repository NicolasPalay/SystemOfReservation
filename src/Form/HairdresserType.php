<?php

namespace App\Form;

use App\Entity\Hairdresser;
use App\Entity\Speciality;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class HairdresserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :role')
                        ->setParameter('role', '%ROLE_HAIRDRESSER%');
                },
            ])
            ->add('picture',FileType::class,[
                'multiple'=>false,
                'label'=>'Ajouter une photo',
                'mapped'=>false,
                'attr' => [
                    'accept' => 'image/jpeg, image/png, image/gif',
                    'onchange' => "previewPictures(this)"
                ]])
            ->add('specialities',EntityType::class,[
                'class'=>Speciality::class,
                'choice_label'=>'nameSpeciality',
                'multiple'=>true,
                'expanded'=>true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hairdresser::class,
        ]);
    }
}
