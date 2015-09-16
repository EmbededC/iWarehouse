<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\Container;

class LoadContainerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $cont1 = new Container();
        $cont1->setCode('000000000000000001');
        $cont1->setContainerType($this->getReference('containertype_europallet'));
        $cont1->setCreatedDate(new \DateTime());
        $cont1->setLocation($this->getReference('location_pulrec'));
        $manager->persist($cont1);
        $manager->flush();
                
        $this->addReference('container_cont1', $cont1);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}