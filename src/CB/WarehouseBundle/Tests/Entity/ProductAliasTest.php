<?php
/*
 * To execute this test: phpunit -c app src/CB/WarehouseBundle/Tests/Entity/ProductAliasTest
 * To execute all tests: phpunit -c app
 */

namespace CB\WarehouseBundle\Tests\Entity;

// This assumes that this class file is located at:
// src/Application/AcmeBundle/Tests/Entity/StockTest.php
// with Symfony 2.0 Standard Edition layout.
require_once __DIR__.'/../../../../../app/AppKernel.php';

//use Symfony\Component\Validator\Validation;
use CB\WarehouseBundle\Entity\ProductAlias;
use CB\WarehouseBundle\Entity\Product;
use CB\WarehouseBundle\Entity\ProductPresentations;
use CB\WarehouseBundle\Validator\Constraints\ValidProductAliasObjectReference;
use CB\WarehouseBundle\Validator\Constraints\ValidProductAliasObjectReferenceValidator;

class ProductAliasTest extends \PHPUnit_Framework_TestCase
{
    private $validator;
    protected static $kernel;
    
    public function setUp()
    {
        self::$kernel = new \AppKernel('dev', true);
        self::$kernel->boot();       
    }
    
    public function testValidStockObjectReferenceValidatorValid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct(10);

        // Now, mock the repository so it returns the mock of the products and presentations
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($product));
        
        //Mock the Entitymanager
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->at(0))
            ->method('getRepository')
            ->with('CBWarehouseBundle:Product')
            ->will($this->returnValue($productRepository));
       
        //Construct the ProductAlias to validate
        $alias = new ProductAlias();
        $alias->setCode('alias');
        $alias->setCreatedDate(new \DateTime());
        $alias->setObjectId(10);
        $alias->setObjectType(0); //0-Product, 1-Presentation
        $alias->setUpdatedDate(new \DateTime());
                
        //Create the context
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        //Create the validator
        $this->validator = new ValidProductAliasObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidProductAliasObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($alias, $constraint);
        $this->assertEquals(0, $result, 'Error validating product alias');
    }
    
    public function testValidStockObjectReferenceValidatorProductInvalid()
    {
        // First, mock the objects to be used in the test
        $presentation = $this->CreateTestProductPresentation(10);

        // Now, mock the repository so it returns the mock of the products and presentations
        $productRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $productRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($presentation));
        
        //Mock the Entitymanager
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->at(0))
            ->method('getRepository')
            ->with('CBWarehouseBundle:Product')
            ->will($this->returnValue($productRepository));
       
        //Construct the ProductAlias to validate
        $alias = new ProductAlias();
        $alias->setCode('alias');
        $alias->setCreatedDate(new \DateTime());
        $alias->setObjectId(10);
        $alias->setObjectType(0); //0-Product, 1-Presentation
        $alias->setUpdatedDate(new \DateTime());

        //Create the context
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        //Create the validator
        $this->validator = new ValidProductAliasObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidProductAliasObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($alias, $constraint);
        $this->assertEquals(1, $result, 'Error validating product alias');
    }
    
    public function testValidStockObjectReferenceValidatorPresentationInvalid()
    {
        // First, mock the objects to be used in the test
        $product = $this->CreateTestProduct(10);
        
        $presentationRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $presentationRepository->expects($this->any())
            ->method('find')
            ->will($this->returnValue($product));

        //Mock the Entitymanager
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->at(0))
            ->method('getRepository')
            ->with('CBWarehouseBundle:ProductPresentations')
            ->will($this->returnValue($presentationRepository));
       
        //Construct the ProductAlias to validate
        $alias = new ProductAlias();
        $alias->setCode('alias');
        $alias->setCreatedDate(new \DateTime());
        $alias->setObjectId(10);
        $alias->setObjectType(1); //0-Product, 1-Presentation
        $alias->setUpdatedDate(new \DateTime());

        //Create the context
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        //Create the validator
        $this->validator = new ValidProductAliasObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidProductAliasObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($alias, $constraint);
        $this->assertEquals(2, $result, 'Error validating product alias');
    }
    
    public function testValidStockObjectReferenceValidatorObjectTypeInvalid()
    {
        //Mock the Entitymanager
        $em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        
        //Construct the ProductAlias to validate
        $alias = new ProductAlias();
        $alias->setCode('alias');
        $alias->setCreatedDate(new \DateTime());
        $alias->setObjectId(10);
        $alias->setObjectType(2); //0-Product, 1-Presentation
        $alias->setUpdatedDate(new \DateTime());
                
        //Create the context
        $context = $this->getMockBuilder('Symfony\Component\Validator\ExecutionContext')-> disableOriginalConstructor()->getMock();
        $context->expects($this->any())
            ->method('addViolation')
            ->with($this->equalTo('[message]'), $this->equalTo(array('%string%', '')));

        //Create the validator
        $this->validator = new ValidProductAliasObjectReferenceValidator($em);
        $this->validator->initialize($context);
        $constraint = new ValidProductAliasObjectReference();
        
        //Verify that a product with a lote and sn with letters and numbers of length 1 or more are valid
        $result = $this->validator->validate($alias, $constraint);
        $this->assertEquals(3, $result, 'Error validating product alias');
    }
        
    private function CreateTestProduct($productId)
    {
        $product = $this->getMock('\CB\WarehouseBundle\Entity\Product');
        $product->expects($this->any())->method('getId')->willReturn($productId);
        $product->expects($this->any())->method('getSnMask')->willReturn('/^([0-9]|[a-zA-Z])+$/'); //A string with numbers and leters with one character or more
        $product->expects($this->any())->method('getSnRequiredInReception')->willReturn(true);
        $product->expects($this->any())->method('getSnRequiredInExpedition')->willReturn(true);
        $product->expects($this->any())->method('getLotMask')->willReturn('/^([0-9]|[a-zA-Z])+$/'); //A string with numbers and leters with one character or more
        $product->expects($this->any())->method('getLotRequiredInReception')->willReturn(true);
        $product->expects($this->any())->method('getLotRequiredInExpedition')->willReturn(true);
        $product->expects($this->any())->method('getPresentation')->willReturn(true);
        
        return $product;
    }
    
    private function CreateTestProductPresentation($presentationProductId)
    {
        $presentationsProduct = $this->getMock('\CB\WarehouseBundle\Entity\Product');
        $presentationsProduct->expects($this->any())->method('getId')->willReturn($presentationProductId);
        
        $presentation = $this->getMock('\CB\WarehouseBundle\Entity\ProductPresentations');
        $presentation->expects($this->any())->method('getProduct')->willReturn($presentationsProduct);

        return $presentation;
    }

}