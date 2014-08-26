<?php

namespace CB\WarehouseBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ProductAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('description')
            ->add('shortDesc')
            ->add('lotRequiredInReception', null, array(
                'required' => false,
            ))
            ->add('lotRequiredInExpedition', null, array(
                'required' => false,
            ))
            ->add('lotMask', null, array(
                'required' => false,
            ))
            ->add('snRequiredInReception', null, array(
                'required' => false,
            ))
            ->add('snRequiredInExpedition', null, array(
                'required' => false,
            ))
            ->add('snMask', null, array(
                'required' => false,
            ))
            ->add('active', null, array(
                'required' => false,
            ))
            ->add('baseUnit')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('description')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('name')
            ->add('description')
        ;
    }
} 