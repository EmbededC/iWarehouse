<?php

namespace CB\WarehouseBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidStockObjectReference extends Constraint
{
    public $message = 'The object reference is not correct: %string%';
    
    public function validatedBy()
    {
        return 'stock_object';
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
