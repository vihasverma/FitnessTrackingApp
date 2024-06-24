<?php

namespace App\UI\Http\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('activityType', ChoiceType::class, [
                'choices' => [
                    'Select Activity Type' => '',
                    'Walking' => 'walking',
                    'Running' => 'running',
                    'Cycling' => 'cycling',
                ],
            ])
            ->add('distance', TextType::class,)
            ->add('distanceUnit', TextType::class)
            ->add('elapsedTime', TextType::class)
            ->add('save', SubmitType::class, array('attr' => array('class' => 'button')));
    }
}