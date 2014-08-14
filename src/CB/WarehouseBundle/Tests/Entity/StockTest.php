<?php
/*
 * To execute this test: phpunit -c app src/CB/WarehouseBundle/Tests/Entity/StockTest
 * To execute all tests: phpunit -c app
 */

namespace CB\WarehouseBundle\Tests\Entity;

// This assumes that this class file is located at:
// src/Application/AcmeBundle/Tests/Entity/StockTest.php
// with Symfony 2.0 Standard Edition layout.
require_once __DIR__.'/../../../../../app/AppKernel.php';

//use Symfony\Component\Validator\Validation;
use CB\WarehouseBundle\Entity\Stock;
use CB\WarehouseBundle\Entity\Product;
use CB\WarehouseBundle\Entity\ProductPresentations;
use CB\WarehouseBundle\Validator\Constraints\ValidStockObjectReference;
use CB\WarehouseBundle\Validator\Constraints\ValidStockObjectReferenceValidator;

class StockTest extends \PHPUnit_Framework_TestCase
{
    private $validator;
    protected static $kernel;
    
    public function setUp()
    {
//        $this->validator = Validation::createValidatorBuilder()
//            ->enableAnnotationMapping()
//            ->getValidator();
        
        self::$kernel = new \AppKernel('dev', true);
        self::$kernel->boot();       
    }
    
    public function testValidStockObjectReferenceValidatorSNAndLotValid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct();
        $container = $this->getMock('\CB\WarehouseBundle\Entity\Container');

        // Now, mock the repository so it returns the mock of the employee
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($product));
        
        $containerRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $containerRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($container));

        //Mock the Entitymanager
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->at(0))
            ->method('getRepository')
            ->with('CBWarehouseBundle:Product')
            ->will($this->returnValue($productRepository));
        $em->expects($this->at(1))
            ->method('getRepository')
            ->with('CBWarehouseBundle:Container')
            ->will($this->returnValue($containerRepository));
       
        //Get one product and one presentation for the new stock
        $stock = new Stock();
        $stock->setProduct($product);
        $stock->setLot('L001');
        $stock->setSn('SN0001');
        $stock->setObjectId(2);
        $stock->setObjectType(Stock::OBJECT_TYPE_CONTAINER);
        
        
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        $this->validator = new ValidStockObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidStockObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($stock, $constraint);
        $this->assertEquals(0, $result, 'Error validating stock');
        
        //$violations = $context->getViolations();
        //$this->assertEquals(0, count($violations));
    }
    
    public function testValidStockObjectReferenceValidatorProductInvalid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct(2);
        $container = $this->getMock('\CB\WarehouseBundle\Entity\Container');

        // Now, mock the repository so it returns the mock of the employee
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($container)); //We return a container when expected a product to produce the error
        
        // Last, mock the EntityManager to return the mock of the repository
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        //Gets a product forever to return a product when expected a container and produce an error
        $em->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($productRepository));
       
        //Get one product and one presentation for the new stock
        $stock = new Stock();
        $stock->setProduct($product);
        $stock->setLot('L001');
        $stock->setSn('SN0001');
        $stock->setObjectId(2); //Object Id inexistent
        $stock->setObjectType(Stock::OBJECT_TYPE_LOCATION);
        
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        $this->validator = new ValidStockObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidStockObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($stock, $constraint);
        $this->assertEquals(1, $result, 'Error validating stock');
        
        //$violations = $context->getViolations();
        //$this->assertEquals(0, count($violations));
    }
        
    public function testValidStockObjectReferenceValidatorSNInvalid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct();
        $container = $this->getMock('\CB\WarehouseBundle\Entity\Container');

        // Now, mock the repository so it returns the mock of the employee
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($product));
        
        $containerRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $containerRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($container));

        // Last, mock the EntityManager to return the mock of the repository
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->at(0))
            ->method('getRepository')
            ->with('CBWarehouseBundle:Product')
            ->will($this->returnValue($productRepository));
       
        //Get one product and one presentation for the new stock
        $stock = new Stock();
        $stock->setProduct($product);
        $stock->setLot('L001');
        $stock->setSn('SN0001_');
        $stock->setObjectId(2);
        $stock->setObjectType(Stock::OBJECT_TYPE_CONTAINER);
        
        
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        $this->validator = new ValidStockObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidStockObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($stock, $constraint);
        $this->assertEquals(2, $result, 'Error validating stock');
        
        //$violations = $context->getViolations();
        //$this->assertEquals(0, count($violations));
    }
    
    public function testValidStockObjectReferenceValidatorLotInvalid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct();
        $container = $this->getMock('\CB\WarehouseBundle\Entity\Container');

        // Now, mock the repository so it returns the mock of the employee
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($product));
        
        $containerRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $containerRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($container));

        // Last, mock the EntityManager to return the mock of the repository
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->at(0))
            ->method('getRepository')
            ->with('CBWarehouseBundle:Product')
            ->will($this->returnValue($productRepository));
       
        //Get one product and one presentation for the new stock
        $stock = new Stock();
        $stock->setProduct($product);
        $stock->setLot('L001_');   //Has a invalid charachter "_"
        $stock->setSn('SN0001');
        $stock->setObjectId(2);
        $stock->setObjectType(Stock::OBJECT_TYPE_CONTAINER);
        
        
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        $this->validator = new ValidStockObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidStockObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($stock, $constraint);
        $this->assertEquals(3, $result, 'Error validating stock');
        
        //$violations = $context->getViolations();
        //$this->assertEquals(0, count($violations));
    }
       
    public function testValidStockObjectReferenceValidatorContainerObjectIdInvalid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct(2);
        $container = $this->getMock('\CB\WarehouseBundle\Entity\Container');

        // Now, mock the repository so it returns the mock of the employee
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($product));
        
        $containerRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $containerRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($container));

        // Last, mock the EntityManager to return the mock of the repository
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        //Gets a product forever to return a product when expected a container and produce an error
        $em->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($productRepository));
       
        //Get one product and one presentation for the new stock
        $stock = new Stock();
        $stock->setProduct($product);
        $stock->setLot('L001');
        $stock->setSn('SN0001');
        $stock->setObjectId(2); //Object Id inexistent
        $stock->setObjectType(Stock::OBJECT_TYPE_CONTAINER);

        
        
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        $this->validator = new ValidStockObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidStockObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($stock, $constraint);
        $this->assertEquals(4, $result, 'Error validating stock');
        
        //$violations = $context->getViolations();
        //$this->assertEquals(0, count($violations));
    }
    
    public function testValidStockObjectReferenceValidatorLocationObjectIdInvalid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct(2);
        $container = $this->getMock('\CB\WarehouseBundle\Entity\Container');

        // Now, mock the repository so it returns the mock of the employee
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($product));
        
        $containerRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $containerRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($container));

        // Last, mock the EntityManager to return the mock of the repository
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        //Gets a product forever to return a product when expected a container and produce an error
        $em->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($productRepository));
       
        //Get one product and one presentation for the new stock
        $stock = new Stock();
        $stock->setProduct($product);
        $stock->setLot('L001');
        $stock->setSn('SN0001');
        $stock->setObjectId(2); //Object Id inexistent
        $stock->setObjectType(Stock::OBJECT_TYPE_LOCATION);

        
        
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        $this->validator = new ValidStockObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidStockObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($stock, $constraint);
        $this->assertEquals(5, $result, 'Error validating stock');
        
        //$violations = $context->getViolations();
        //$this->assertEquals(0, count($violations));
    }
    
    public function testValidStockObjectReferenceValidatorObjectTypeInvalid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct(2);
        $container = $this->getMock('\CB\WarehouseBundle\Entity\Container');

        // Now, mock the repository so it returns the mock of the employee
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($product));
        
        $containerRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $containerRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($container));

        // Last, mock the EntityManager to return the mock of the repository
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->at(0))
            ->method('getRepository')
            ->with('CBWarehouseBundle:Product')
            ->will($this->returnValue($productRepository));
       
        //Get one product and one presentation for the new stock
        $stock = new Stock();
        $stock->setProduct($product);
        $stock->setLot('L001');
        $stock->setSn('SN0001');
        $stock->setObjectId(2);
        $stock->setObjectType(2); //Object Type inexistent

        
        
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        $this->validator = new ValidStockObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidStockObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($stock, $constraint);
        $this->assertEquals(6, $result, 'Error validating stock');
        
        //$violations = $context->getViolations();
        //$this->assertEquals(0, count($violations));
    }
    
    private function CreateTestProduct()
    {
        $product = $this->getMock('\CB\WarehouseBundle\Entity\Product');
        $product->expects($this->any())->method('getId')->willReturn(10);
        $product->expects($this->any())->method('getSnMask')->willReturn('/^([0-9]|[a-zA-Z])+$/'); //A string with numbers and leters with one character or more
        $product->expects($this->any())->method('getSnRequiredInReception')->willReturn(true);
        $product->expects($this->any())->method('getSnRequiredInExpedition')->willReturn(true);
        $product->expects($this->any())->method('getLotMask')->willReturn('/^([0-9]|[a-zA-Z])+$/'); //A string with numbers and leters with one character or more
        $product->expects($this->any())->method('getLotRequiredInReception')->willReturn(true);
        $product->expects($this->any())->method('getLotRequiredInExpedition')->willReturn(true);
        
        return $product;
    }

}