<?php

namespace MiCocinaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedidaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('cantidad', IntegerType::class)
            /*->add('isAttending', ChoiceType::class, array(
                'choices'  => array(
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ),
                // *this line is important*
                'choices_as_values' => true,
                'mapped'=>false
            ))*/
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MiCocinaBundle\Entity\Medida'
        ));
    }
}
