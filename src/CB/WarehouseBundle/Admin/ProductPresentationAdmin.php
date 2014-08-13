<?php

namespace CB\WarehouseBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ProductPresentationAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
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

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('baseUnitQuantity')
            ->add('weight')
            ->add('sizeX')
            ->add('sizeY')
            ->add('sizeZ')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('name')
            ->add('description')
            ->add('baseUnitQuantity')
            ->add('weight')
            ->add('sizeX')
            ->add('sizeY')
            ->add('sizeZ')
        ;
    }
} 