<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('color', TextType::class)
            ->add('special', TextType::class, array(
                'required' => false
            ))
            ->add('size', TextType::class)
            ->add('price', IntegerType::class)
            ->add('stock', IntegerType::class)
            ->add('image', TextType::class, array(
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cord'
        ));
    }

    public function getName()
    {
        return 'app_bundle_cord_type';
    }
}
