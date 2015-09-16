<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\EventReason;

class LoadEventReasonData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $reason1 = new EventReason();
        $reason1->setCode('STOCK_FOUND');
        $reason1->setDescription('Stock found');
        $manager->persist($reason1);
        
        $reason2 = new EventReason();
        $reason2->setCode('STOCK_LOST');
        $reason2->setDescription('Stock lost');
        $manager->persist($reason2);
        
        $reason3 = new EventReason();
        $reason3->setCode('STOCK_RECEIVED');
        $reason3->setDescription('Stock received');
        $manager->persist($reason3);
        
        $reason4 = new EventReason();
        $reason4->setCode('STOCK_SEND');
        $reason4->setDescription('Stock send');
        $manager->persist($reason4);
        
        $reason5 = new EventReason();
        $reason5->setCode('STOCK_COUNT');
        $reason5->setDescription('Stock count');
        $manager->persist($reason5);
        
        $reason6 = new EventReason();
        $reason6->setCode('STOCK_PICKING');
        $reason6->setDescription('Stock picking');
        $manager->persist($reason6);

        $manager->flush();
        
        $this->addReference('reason_1', $reason1);
        $this->addReference('reason_2', $reason2);
        $this->addReference('reason_3', $reason3);
        $this->addReference('reason_4', $reason4);
        $this->addReference('reason_5', $reason5);
        $this->addReference('reason_6', $reason6);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}