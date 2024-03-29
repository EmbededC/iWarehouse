<?php

namespace CB\WarehouseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StockType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('baseQuantity')
            ->add('lot')
            ->add('sn')
            ->add('expiryDate')
            ->add('bestBeforeDate')
            ->add('recivedDate')
            ->add('productionDate')
            ->add('objectId') //, null, array('help' => 'Container Id or Location Id'))
            ->add('objectType') //, null, array('help' => 'Object Id type: 0 - Container, 1 - Location'))
            ->add('product')
            ->add('presentation')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CB\WarehouseBundle\Entity\Stock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cb_warehousebundle_stock';
    }
}
