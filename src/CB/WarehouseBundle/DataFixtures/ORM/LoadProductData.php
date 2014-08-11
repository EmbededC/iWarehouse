<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $cocacola = new Product();
        $cocacola->setName('cocacola 2L');
        $cocacola->setShortDesc('cocacola 2L b.');
        $cocacola->setDescription('cocacola 2L bottle');
        $cocacola->setBaseUnit($this->getReference('productbaseunit_unit'));
        $cocacola->setCreatedDate(new \DateTime());
        $cocacola->setLotRequiredInReception(true);
        $cocacola->setLotRequiredInExpedition(true);
        $cocacola->setSnRequiredInReception(true);
        $cocacola->setSnRequiredInExpedition(true);
        $manager->persist($cocacola);
        $manager->flush();
                
        $this->addReference('product_cocacola', $cocacola);
        
        /*
        $sprite = new Product();
        $sprite->setName('sprite');
        $sprite->setShortDesc('sprite');
        $sprite->setDescription('sprite');
        $sprite->setBaseUnit($this->getReference('productbaseunit_unit'));
        $sprite->setCreatedDate(new \DateTime());
        $manager->persist($sprite);
        $manager->flush();
                
        $this->addReference('product_sprite', $sprite);
        
        $fanta = new Product();
        $fanta->setName('fanta');
        $fanta->setShortDesc('fanta');
        $fanta->setDescription('fanta');
        $fanta->setBaseUnit($this->getReference('productbaseunit_unit'));
        $fanta->setCreatedDate(new \DateTime());
        $manager->persist($fanta);
        $manager->flush();
                
        $this->addReference('product_fanta', $fanta);
         * 
         */
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}