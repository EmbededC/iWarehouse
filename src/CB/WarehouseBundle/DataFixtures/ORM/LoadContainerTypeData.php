<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\ContainerType;

class LoadContainerTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $europallet = new ContainerType();
        $europallet->setName('Europallet');
        $europallet->setDescription('Europallet');
        $europallet->setCreatedDate(new \DateTime());
        $europallet->setMaxWeight(1000);
        $europallet->setSizeX(800);
        $europallet->setSizeY(1200);
        $europallet->setSizeZ(144);
        $manager->persist($europallet);
        $manager->flush();
        
        $this->addReference('containertype_europallet', $europallet);
        
        $american = new ContainerType();
        $american->setName('American');
        $american->setDescription('American');
        $american->setCreatedDate(new \DateTime());
        $american->setMaxWeight(1000);
        $american->setSizeX(1000);
        $american->setSizeY(1200);
        $american->setSizeZ(144);
        $manager->persist($american);
        $manager->flush();
        
        $this->addReference('containertype_american', $american);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}