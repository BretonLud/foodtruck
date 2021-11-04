<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tab = [
            'Utilisateur' => 'ROLE_USER',
            'Abonné' => 'ROLE_ABONNE',
            'Modérateur' => 'ROLE_MODO',
            'Administrateur' => 'ROLE_ADMIN'
        ];

        $admin = $builder->getData()->getRoles();

        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir une adresse email'
                    ])
                ],
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label'=> 'Email: '
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => $tab,
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles: ',
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
