<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\Location;

class LoadLocationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $pulrec = new Location();
        $pulrec->setCode('PUL-REC');
        $pulrec->setLocationType($this->getReference('locationtype_buffer'));
        $pulrec->setCreatedDate(new \DateTime());
        $manager->persist($pulrec);
        $manager->flush();
                
        $this->addReference('location_pulrec', $pulrec);
        
        $pulexp = new Location();
        $pulexp->setCode('PUL-EXP');
        $pulexp->setLocationType($this->getReference('locationtype_buffer'));
        $pulexp->setCreatedDate(new \DateTime());
        $manager->persist($pulexp);
        $manager->flush();
                
        $this->addReference('location_pulexp', $pulexp);
        
        $bufalm = new Location();
        $bufalm->setCode('BUF-ALM');
        $bufalm->setLocationType($this->getReference('locationtype_buffer'));
        $bufalm->setCreatedDate(new \DateTime());
        $manager->persist($bufalm);
        $manager->flush();
                
        $this->addReference('location_bufalm', $bufalm);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}