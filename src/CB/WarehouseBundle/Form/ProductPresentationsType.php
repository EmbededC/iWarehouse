<?php

namespace CB\WarehouseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductPresentationsType extends AbstractType
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
            ->add('baseUnitQuantity')
            ->add('weight')
            ->add('sizeX')
            ->add('sizeY')
            ->add('sizeZ')
            ->add('canDivide', null, array(
                'required' => false,
            ))
            ->add('isPreferred', null, array(
                'required' => false,
            ))
            ->add('isBase', null, array(
                'required' => false,
            ))
            ->add('createdDate')
            ->add('updatedDate')
            ->add('product')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CB\WarehouseBundle\Entity\ProductPresentations'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cb_warehousebundle_productpresentations';
    }
}
