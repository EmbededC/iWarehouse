<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\Provider;

class LoadProviderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $provider1 = new Provider();
        $provider1->setName('Provider 1');
        $provider1->setDescription('Provider 1 for test');
        $manager->persist($provider1);
        $manager->flush();
        
        $this->addReference('provider_1', $provider1);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}