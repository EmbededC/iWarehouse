<?php
/*
 * To execute this test: phpunit -c app src/CB/WarehouseBundle/Tests/Controller/DefaultControllerTest
 * To execute all tests: phpunit -c app
 */

namespace CB\WarehouseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        //Get the main page with all the stock functions
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET ");

        //Verify that the options are descrived
        $this->assertTrue($crawler->filter('html:contains("Add stock")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Inc/Dec stock")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Modify stock attributes")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Move stock")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Delete stock")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Split stock")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("Merge stock")')->count() > 0);
    }
}