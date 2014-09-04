<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\EventType;

class LoadEventTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $eventtype1 = new EventType();
        $eventtype1->setCode('CREATE');
        $eventtype1->setDescription('Create object event');
        $manager->persist($eventtype1);
        
        $eventtype2 = new EventType();
        $eventtype2->setCode('READ');
        $eventtype2->setDescription('Read object event');
        $manager->persist($eventtype2);
        
        $eventtype3 = new EventType();
        $eventtype3->setCode('UPDATE');
        $eventtype3->setDescription('Update object event');
        $manager->persist($eventtype3);
        
        $eventtype4 = new EventType();
        $eventtype4->setCode('DELETE');
        $eventtype4->setDescription('Delete object event');
        $manager->persist($eventtype4);
        
        $manager->flush();
        
        $this->addReference('event_type_1', $eventtype1);
        $this->addReference('event_type_2', $eventtype2);
        $this->addReference('event_type_3', $eventtype3);
        $this->addReference('event_type_4', $eventtype4);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}