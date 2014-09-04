<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\Event;

class LoadEventData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setCode('STOCK_CREATE');
        $event1->setDescription('Event launched when a user wants to create stock');
        $manager->persist($event1);
        
        $event2 = new Event();
        $event2->setCode('STOCK_INCDEC');
        $event2->setDescription('Event launched when a user wants to inc/dec stock');
        $manager->persist($event2);
        
        $event3 = new Event();
        $event3->setCode('STOCK_MODIFY');
        $event3->setDescription('Event launched when a user wants to modify stock');
        $manager->persist($event3);
        
        $event4 = new Event();
        $event4->setCode('STOCK_MOVE');
        $event4->setDescription('Event launched when a user wants to move stock');
        $manager->persist($event4);
        
        $event5 = new Event();
        $event5->setCode('STOCK_DELETE');
        $event5->setDescription('Event launched when a user wants to delete stock');
        $manager->persist($event5);
        
        $manager->flush();
        
        $this->addReference('event_1', $event1);
        $this->addReference('event_2', $event2);
        $this->addReference('event_3', $event3);
        $this->addReference('event_4', $event4);
        $this->addReference('event_5', $event5);
        
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}