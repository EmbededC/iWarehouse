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
        $cocacola->setLotMask(null);
        $cocacola->setSnRequiredInReception(true);
        $cocacola->setSnRequiredInExpedition(true);
        $cocacola->setSnMask(null);
        $manager->persist($cocacola);
        $manager->flush();
                
        $this->addReference('product_cocacola', $cocacola);
        
        $sprite = new Product();
        $sprite->setName('sprite 2L');
        $sprite->setShortDesc('sprite 2L b.');
        $sprite->setDescription('sprite 2L bottle');
        $sprite->setBaseUnit($this->getReference('productbaseunit_unit'));
        $sprite->setCreatedDate(new \DateTime());
        $sprite->setLotRequiredInReception(true);
        $sprite->setLotRequiredInExpedition(true);
        $sprite->setLotMask(null);
        $sprite->setSnRequiredInReception(true);
        $sprite->setSnRequiredInExpedition(true);
        $sprite->setSnMask(null);
        $manager->persist($sprite);
        $manager->flush();
                
        $this->addReference('product_sprite', $sprite);
        
        $fanta = new Product();
        $fanta->setName('fanta 2L');
        $fanta->setShortDesc('fanta 2L b.');
        $fanta->setDescription('fanta 2L bottle');
        $fanta->setBaseUnit($this->getReference('productbaseunit_unit'));
        $fanta->setCreatedDate(new \DateTime());
        $fanta->setLotRequiredInReception(true);
        $fanta->setLotRequiredInExpedition(true);
        $fanta->setLotMask(null);
        $fanta->setSnRequiredInReception(true);
        $fanta->setSnRequiredInExpedition(true);
        $fanta->setSnMask(null);
        $manager->persist($fanta);
        $manager->flush();
                
        $this->addReference('product_fanta', $fanta);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}