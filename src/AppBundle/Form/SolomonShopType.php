<?php

namespace AppBundle\Form;

use AppBundle\Entity\Accent;
use AppBundle\Entity\Cord;
use AppBundle\Entity\Size;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SolomonShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color1', EntityType::class, [
            'class' => Cord::class,
            'label' => 'Outer Color',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where("u.special IS NULL")
                    ->orWhere("u.special = 'Reflective'")
                    ->orderBy('u.color');
            }
            ])

            ->add('color2', EntityType::class, [
                'class' => Cord::class,
                'label' => 'Inner Color',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where("u.special IS NULL")
                        ->orWhere("u.special = 'Reflective'")
                        ->orderBy('u.color');
                }
            ])

            ->add('size', EntityType::class, [
                'class' => Size::class,
                'label' => 'Size'
            ])

            ->add('quantity', IntegerType::class, [
                'data' => 1
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'app_bundle_solomon_shop_type';
    }
}
