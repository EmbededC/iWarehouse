<?php

namespace CB\WarehouseBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class StockAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('quantity')
            ->add('baseQuantity')
            ->add('lot')
            ->add('sn')
            ->add('expiryDate')
            ->add('bestBeforeDate')
            ->add('recivedDate')
            ->add('productionDate')
            ->add('createdDate')
            ->add('updatedDate')
            ->add('objectId')
            ->add('objectType')
            ->add('product')
            ->add('presentation')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('quantity')
            ->add('baseQuantity')
            ->add('lot')
            ->add('sn')
            ->add('expiryDate')
            ->add('bestBeforeDate')
            ->add('recivedDate')
            ->add('productionDate')
            ->add('objectId')
            ->add('objectType')
            ->add('product')
            ->add('presentation')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('quantity')
            ->add('baseQuantity')
            ->add('lot')
            ->add('sn')
            ->add('expiryDate')
            ->add('bestBeforeDate')
            ->add('recivedDate')
            ->add('productionDate')
            ->add('objectId')
            ->add('objectType')
            ->add('product')
            ->add('presentation')
        ;
    }
} 