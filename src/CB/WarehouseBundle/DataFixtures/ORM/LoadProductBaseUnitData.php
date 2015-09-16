<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\ProductBaseUnit;

class LoadProductBaseUnitData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $unit = new ProductBaseUnit();
        $unit->setName('Unit');
        $unit->setDescription('Unit');
        $manager->persist($unit);
        $manager->flush();
        
        $this->addReference('productbaseunit_unit', $unit);
        
        $liter = new ProductBaseUnit();
        $liter->setName('Liter');
        $liter->setDescription('Liter');
        $manager->persist($liter);
        $manager->flush();
        
        $this->addReference('productbaseunit_liter', $liter);
        
        $meter = new ProductBaseUnit();
        $meter->setName('Meter');
        $meter->setDescription('Meter');
        $manager->persist($meter);
        $manager->flush();
        
        $this->addReference('productbaseunit_meter', $meter);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}