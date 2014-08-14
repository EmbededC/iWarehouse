<?php

namespace CB\WarehouseBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class that verifies if the objectId and objectType Stock attribtues are valid and exists
 * Object type is valid if:
 * - 0: Container
 * - 1: Location
 */
class ValidStockObjectReferenceValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function validate($stock, Constraint $constraint)
    {
        //Validation of product required fields
        $product = $this->entityManager->getRepository('CBWarehouseBundle:Product')->find($stock->getProduct()->getId());
        if (!$product instanceof \CB\WarehouseBundle\Entity\Product) {
            $this->context->addViolationAt(
                'Stock',
                $constraint->message,
                array('%string%' => 'Can\'t find the product'),
                null
            );
            return 1;
        }
        
        //SerialNumber Validation
        if ($product->getSnMask())
        {
            if ($product->getSnRequiredInReception() &&  $product->getSnRequiredInExpedition())
            {
                if (!preg_match($product->getSnMask(), $stock->getSn()))
                {
                    $this->context->addViolationAt(
                        'Stock',
                        $constraint->message,
                        array('%string%' => 'The stock SN and the product SnMask doesn\'t match'),
                        null
                    );
                    return 2;
                }
            }
        }
        
        //Lote Validation
        if ($product->getLotMask())
        {
            if ($product->getLotRequiredInReception() &&  $product->getLotRequiredInExpedition())
            {
                if (!preg_match($product->getLotMask(), $stock->getLot()))
                {
                    $this->context->addViolationAt(
                        'Stock',
                        $constraint->message,
                        array('%string%' => 'The stock Lot and the product LotMask doesn\'t match'),
                        null
                    );
                    return 3;
                }
            }
        }
        
        //Validation of ObjectId and ObjectType
        if (is_null($stock->getObjectType()))
        {
            $this->context->addViolationAt(
                'Stock',
                $constraint->message,
                array('%string%' => 'The stock ObjectType must have a value'),
                null
            );
            return 7;
        }
        
        switch($stock->getObjectType())
        {
            case 0: //Container
                $container = $this->entityManager->getRepository('CBWarehouseBundle:Container')->find($stock->getObjectId());
                //Verify that the container exists
                if (!$container instanceof \CB\WarehouseBundle\Entity\Container) {
                    $this->context->addViolationAt(
                        'Stock',
                        $constraint->message,
                        array('%string%' => 'Check the Object Id field, a container with this id doesn\'t exists'),
                        null
                    );
                    return 4;
                }
                break;
            case 1: //Location
                $location = $this->entityManager->getRepository('CBWarehouseBundle:Location')->find($stock->getObjectId());
                //Verify that the location exists
                if (!$location instanceof \CB\WarehouseBundle\Entity\Location) {
                    $this->context->addViolationAt(
                        'Stock',
                        $constraint->message,
                        array('%string%' => 'Check the Object Id field, a location with this id doesn\'t exists'),
                        null
                    );
                    return 5;
                }
                break;
            default:
                $this->context->addViolationAt(
                    'Stock',
                    $constraint->message,
                    array('%string%' => 'The Object Type field is not valid. Use 0 for container and 1 for location'),
                    null
                );
                return 6;
                break;
        }
        
        return 0;
    }
}