<?php

namespace CB\WarehouseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('shortDesc')
            ->add('lotRequiredInReception', null, array(
                'required' => false,
            ))
            ->add('lotRequiredInExpedition', null, array(
                'required' => false,
            ))
            ->add('snRequiredInReception', null, array(
                'required' => false,
            ))
            ->add('snRequiredInExpedition', null, array(
                'required' => false,
            ))
            ->add('active', null, array(
                'required' => false,
            ))
            ->add('lotMask')
            ->add('snMask')
            ->add('baseUnit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CB\WarehouseBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cb_warehousebundle_product';
    }
}
