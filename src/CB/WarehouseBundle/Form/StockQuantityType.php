<?php

namespace CB\WarehouseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StockQuantityType extends AbstractType
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
            ->add('lot', null, array('disabled' => true))
            ->add('sn', null, array('disabled' => true))
            ->add('expiryDate', null, array('disabled' => true))
            ->add('bestBeforeDate', null, array('disabled' => true))
            ->add('recivedDate', null, array('disabled' => true))
            ->add('productionDate', null, array('disabled' => true))
            ->add('createdDate', null, array('disabled' => true))
            ->add('updatedDate', null, array('disabled' => true))
            ->add('objectId', null, array('disabled' => true)) //, null, array('help' => 'Container Id or Location Id'))
            ->add('objectType', null, array('disabled' => true)) //, null, array('help' => 'Object Id type: 0 - Container, 1 - Location'))
            ->add('product', null, array('disabled' => true))
            ->add('presentation', null, array('disabled' => true))
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
