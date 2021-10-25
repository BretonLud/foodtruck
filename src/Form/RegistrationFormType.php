<?php

namespace App\Form;

use App\Entity\User;
use App\Form\FormExtension\HoneyPotType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends HoneyPotType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email: ',
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes doivent être identiques.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe: '],
                'second_options' => ['label' => 'Confirmer le mot de passe: '],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Mot de passe requis',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins{{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                    ]),
                    new Regex('((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,64})',
                        "Votre mot de passe doit contenir 1 majuscule, 1 chiffre et 1 caractère spécial")
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
