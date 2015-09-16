<?php
/*
 * To execute this test: phpunit -c app src/CB/WarehouseBundle/Tests/Controller/StockControllerTest
 * To execute all tests: phpunit -c app
 */

namespace CB\WarehouseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StockControllerTest extends WebTestCase
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
    
    public function testCompleteScenario()
    {        
        $product = $this->em->getRepository('CBWarehouseBundle:Product')->findOneByName('cocacola 2L');
        $presentation = $this->em->getRepository('CBWarehouseBundle:ProductPresentations')->findOneByName('cocacola 2L Bottle');
        $locationALM = $this->em->getRepository('CBWarehouseBundle:Location')->findOneByCode('BUF-ALM');
        $locationEXP = $this->em->getRepository('CBWarehouseBundle:Location')->findOneByCode('PUL-EXP');
        
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /stock/");
        
        
        //**********************************************************************
        // Add Stock : Creates a new stock into BUF-ALM
        //**********************************************************************
        $crawler = $client->click($crawler->selectLink('Add stock')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'cb_warehousebundle_stock[quantity]' => '10',
            'cb_warehousebundle_stock[baseQuantity]' => '10',
            'cb_warehousebundle_stock[lot]' => 'LOT240',
            'cb_warehousebundle_stock[sn]' => 'SN240',
            'cb_warehousebundle_stock[expiryDate][date][year]' => '2014',
            'cb_warehousebundle_stock[expiryDate][date][month]' => '8',
            'cb_warehousebundle_stock[expiryDate][date][day]' => '2',
            'cb_warehousebundle_stock[expiryDate][time][hour]' => '14',
            'cb_warehousebundle_stock[expiryDate][time][minute]' => '20',
            'cb_warehousebundle_stock[bestBeforeDate][date][year]' => '2014',
            'cb_warehousebundle_stock[bestBeforeDate][date][month]' => '8',
            'cb_warehousebundle_stock[bestBeforeDate][date][day]' => '2',
            'cb_warehousebundle_stock[bestBeforeDate][time][hour]' => '14',
            'cb_warehousebundle_stock[bestBeforeDate][time][minute]' => '20',
            'cb_warehousebundle_stock[recivedDate][date][year]' => '2014',
            'cb_warehousebundle_stock[recivedDate][date][month]' => '8',
            'cb_warehousebundle_stock[recivedDate][date][day]' => '2',
            'cb_warehousebundle_stock[recivedDate][time][hour]' => '14',
            'cb_warehousebundle_stock[recivedDate][time][minute]' => '20',
            'cb_warehousebundle_stock[productionDate][date][year]' => '2014',
            'cb_warehousebundle_stock[productionDate][date][month]' => '8',
            'cb_warehousebundle_stock[productionDate][date][day]' => '2',
            'cb_warehousebundle_stock[productionDate][time][hour]' => '14',
            'cb_warehousebundle_stock[productionDate][time][minute]' => '20',
            'cb_warehousebundle_stock[objectId]' => $locationALM->getId(),
            'cb_warehousebundle_stock[objectType]' => '1',
            'cb_warehousebundle_stock[product]' => $product->getId(),
            'cb_warehousebundle_stock[presentation]' => $presentation->getId(),
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $stocksFound = $crawler->filter('td:contains("cocacola 2L")')->count();
        $this->assertGreaterThan(0, $stocksFound, 'Missing element td:contains("cocacola 2L")');

        
        //**********************************************************************
        // Inc/Dec Stock : Changes the quantity of the stock
        //**********************************************************************
        $crawler = $client->click($crawler->selectLink('Inc/Dec')->last()->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Update')->form(array(
            'cb_warehousebundle_stock[quantity]' => '20',
            'cb_warehousebundle_stock[baseQuantity]' => '20',
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        
        // Check data in the show view
        $this->assertEquals($stocksFound, $crawler->filter('td:contains("cocacola 2L")')->count(), 'Missing element td:contains("cocacola 2L")');

        //**********************************************************************
        // Modify Stock : Changes the Lot and SN. Attention is there is another stock into the location with the same lot and sn will merge
        //**********************************************************************
        $crawler = $client->click($crawler->selectLink('Modify')->last()->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Update')->form(array(
            'cb_warehousebundle_stock[lot]' => 'LOT240',
            'cb_warehousebundle_stock[sn]' => 'SN240',
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        
        // Check data in the show view
        $this->assertEquals($stocksFound, $crawler->filter('td:contains("cocacola 2L")')->count(), 'Missing element td:contains("cocacola 2L")');

        //**********************************************************************
        // Move Stock : Moves to PUL-EXP. Attention is there is another stock into the location with the same lot and sn will merge
        //**********************************************************************
        $crawler = $client->click($crawler->selectLink('Move')->last()->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Update')->form(array(
            'cb_warehousebundle_stock[objectId]' => $locationEXP->getId(),
            'cb_warehousebundle_stock[objectType]' => '1',
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        
        // Check data in the show view
        $this->assertEquals($stocksFound, $crawler->filter('td:contains("cocacola 2L")')->count(), 'Missing element td:contains("cocacola 2L")');

        //**********************************************************************
        // Split Stock : Splits and puths the new stock into BUF-ALM. Attention is there is another stock into the location with the same lot and sn will merge
        //**********************************************************************
        $crawler = $client->click($crawler->selectLink('Split')->last()->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Update')->form(array(
            'cb_warehousebundle_stock[objectId]' => $locationALM->getId(),
            'cb_warehousebundle_stock[objectType]' => '1',
            'cb_warehousebundle_stock[quantity]' => '5',
            'cb_warehousebundle_stock[baseQuantity]' => '5',
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        
        // Check data in the show view
        $this->assertEquals($stocksFound + 1, $crawler->filter('td:contains("cocacola 2L")')->count(), 'Missing element td:contains("cocacola 2L")');

        //**********************************************************************
        // Move Stock and Merge with the splited in the previouse step
        //**********************************************************************
        $crawler = $client->click($crawler->selectLink('Move')->last()->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Update')->form(array(
            'cb_warehousebundle_stock[objectId]' => $locationEXP->getId(),
            'cb_warehousebundle_stock[objectType]' => '1',
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        
        // Check data in the show view
        $this->assertEquals($stocksFound, $crawler->filter('td:contains("cocacola 2L")')->count(), 'Missing element td:contains("cocacola 2L")');

        //**********************************************************************
        // Delete the entity
        //**********************************************************************
        $crawler = $client->click($crawler->selectLink('Delete')->last()->link());
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();
        
        // Check the entity has been delete on the list
        $this->assertGreaterThan($crawler->filter('td:contains("cocacola 2L")')->count(), $stocksFound, 'Missing element td:contains("cocacola 2L")');
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
