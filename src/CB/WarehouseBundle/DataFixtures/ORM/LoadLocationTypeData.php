<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\LocationType;

class LoadLocationTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $buffer = new LocationType();
        $buffer->setName('Buffer');
        $buffer->setDescription('Buffer');
        $buffer->setCreatedDate(new \DateTime());
        $manager->persist($buffer);
        $manager->flush();
        
        $this->addReference('locationtype_buffer', $buffer);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}