<?php

namespace CB\WarehouseBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class that verifies if the objectId and objectType ProductAlias attribtues are valid and exists
 * Object type is valid if:
 * - 0: Product
 * - 1: Presentation
 */
class ValidProductAliasObjectReferenceValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function validate($productAlias, Constraint $constraint)
    {
        switch($productAlias->getObjectType())
        {
            case 0: //Product
                $product = $this->entityManager->getRepository('CBWarehouseBundle:Product')->find($productAlias->getObjectId());
                //Verify that the product exists
                if (!$product instanceof \CB\WarehouseBundle\Entity\Product) {
                    $this->context->addViolationAt(
                        'ProductAlias',
                        $constraint->message,
                        array('%string%' => 'Check the Object Id field, a product with this id doesn\'t exists'),
                        null
                    );
                }
                break;
            case 1: //Presentation
                $presentation = $this->entityManager->getRepository('CBWarehouseBundle:ProductPresentations')->find($productAlias->getObjectId());
                //Verify that the presentation exists
                if (!$presentation instanceof \CB\WarehouseBundle\Entity\ProductPresentations) {
                    $this->context->addViolationAt(
                        'ProductAlias',
                        array('%string%' => 'Check the Object Id field, a presentation with this id doesn\'t exists'),
                        array(),
                        null
                    );
                }
                break;
            default:
                $this->context->addViolationAt(
                    'ProductAlias',
                    $constraint->message,
                    array('%string%' => 'The Object Type field is not valid. Use 0 for product and 1 for presentation'),
                    null
                );
                break;
        }
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}