<?php

namespace App\Form;

use App\Entity\ContactRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'attr' => [
                    'placeholder' => "John"
                ]
            ])
            ->add('last_name', TextType::class, [
                'attr' => [
                    'placeholder' => "Doe"
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => "johndoe@wiredbeauty.com"
                ]
            ])
            ->add('phone', TextType::class)
            ->add('subject', TextType::class)
            ->add('message', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactRequest::class,
        ]);
    }
}
