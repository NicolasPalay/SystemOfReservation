<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Hairdresser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateTimeType::class,[

                'widget' => 'single_text',
                'html5' => true,


            ])
            ->add('hairdresser', EntityType::class, [
                'class' => Hairdresser::class,
                'choice_label' => 'user.fullName',
                'placeholder' => 'Choissez votre coiffeur',
                'label' => 'Coiffeurs(ses)',])
        ->add('speciality',null,['choice_label' => 'nameSpeciality',
            'label' => 'Spécialités',
            'placeholder' => 'Choissez votre coiffure',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
