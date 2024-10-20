<?php

namespace App\Form;

use App\Entity\Material;
use App\Entity\TVA;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('priceHT', NumberType::class, [
                'scale' => 2,
                'label' => 'Prix HT',
            ])
            ->add('priceTTC', NumberType::class, [
                'scale' => 2,
                'label' => 'Prix TTC',
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
            ])
            ->add('tva', EntityType::class, [
                'class' => TVA::class,
                'label' => 'TVA',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'modifier',
                'attr' => [
                    'class' => 'button button--secondary button--submit',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }
}
