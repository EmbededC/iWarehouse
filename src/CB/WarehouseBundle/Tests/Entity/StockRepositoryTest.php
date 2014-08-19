<?php
/*
 * To execute this test: phpunit -c app src/CB/WarehouseBundle/Tests/Entity/StockRepositoryTest
 * To execute all tests: phpunit -c app
 */


namespace CB\WarehouseBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StockRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindEqual()
    {
        $stock = new \CB\WarehouseBundle\Entity\Stock();
        
        //Test can't find stock
        $stockFound = $this->em
            ->getRepository('CBWarehouseBundle:Stock')
            ->findEqual($stock);

        $this->assertNull($stockFound);
        
        //Test can find stock. Note: There must be one stock into the database for the test!
        $stocks = $this->em->getRepository('CBWarehouseBundle:Stock')->findAll();
        
        $stockFound = $this->em
            ->getRepository('CBWarehouseBundle:Stock')
            ->findEqual($stocks[0]);
                
        $this->assertNotNull($stockFound);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}