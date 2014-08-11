<?php

namespace CB\WarehouseBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CB\WarehouseBundle\Entity\ProductPresentations;

class LoadProductPresentationsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $cocacola2l = new ProductPresentations();
        $cocacola2l->setProduct($this->getReference('product_cocacola'));
        $cocacola2l->setName('2L Bottle');
        $cocacola2l->setDescription('2L Bottle');
        $cocacola2l->setBaseUnitQuantity(1);
        $cocacola2l->setCreatedDate(new \DateTime());
        $cocacola2l->setSizeX(1);
        $cocacola2l->setSizeY(1);
        $cocacola2l->setSizeZ(1);
        $cocacola2l->setWeight(2);
        $cocacola2l->setIsBase(true);
        $cocacola2l->setCanDivide(false);
        $cocacola2l->setIsPreferred(true);
        $manager->persist($cocacola2l);
        $manager->flush();
        
        $this->addReference('productpresentation_cocacola2L', $cocacola2l);
        
        $cocacola6p2l = new ProductPresentations();
        $cocacola6p2l->setProduct($this->getReference('product_cocacola'));
        $cocacola6p2l->setName('Pack 6 x 2L Bottle');
        $cocacola6p2l->setDescription('Pack 6 x 2L Bottle');
        $cocacola6p2l->setBaseUnitQuantity(6);
        $cocacola6p2l->setCreatedDate(new \DateTime());
        $cocacola6p2l->setSizeX(3);
        $cocacola6p2l->setSizeY(2);
        $cocacola6p2l->setSizeZ(1);
        $cocacola6p2l->setWeight(12);
        $cocacola6p2l->setIsBase(false);
        $cocacola6p2l->setCanDivide(true);
        $cocacola6p2l->setIsPreferred(false);
        $manager->persist($cocacola6p2l);
        $manager->flush();
        
        $this->addReference('productpresentation_cocacola6P2L', $cocacola6p2l);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}