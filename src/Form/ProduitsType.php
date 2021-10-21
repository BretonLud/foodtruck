<?php

namespace App\Form;

use App\Entity\Produits;
use App\Entity\Option;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('prix', MoneyType::class, [
                'label' => 'Prix: '
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'constraints' => new File([
                    'mimeTypes' => [
                        'image/*'
                    ],
                    'mimeTypesMessage' => "Veuillez mettre des fichiers format image"
                ])
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])
            ->add('stock')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
            'translation_domain' => 'forms'
        ]);
    }
}
