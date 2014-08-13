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
        //*$em = $this->getDoctrine()->getManager();

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
                }
                break;
            default:
                $this->context->addViolationAt(
                    'Stock',
                    $constraint->message,
                    array('%string%' => 'The Object Type field is not valid. Use 0 for container and 1 for location'),
                    null
                );
                break;
        }
    }
}