<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * StockRepository
 *
 */
class StockRepository extends EntityRepository
{
        
    /**
     * Gets the first stock that has the same attributes (except quantity) that
     * the stock passed as a parameter
     * 
     * @return \CB\WarehouseBundle\Entity\Stock or null if not found
     */
    public function findEqual(\CB\WarehouseBundle\Entity\Stock $stock)
    {
        //This sentence doesn't works in tests
        //$repository = $this->getDoctrine()->getManager()->getRepository('CBWarehouseBundle:Stock');
        
        //This sentence works in tests
        $repository = $this->getEntityManager()->getRepository('CBWarehouseBundle:Stock');
        
        //Stocks found in the same container/location
        $stocksFound = $repository->findBy(array('objectId' => $stock->getObjectId(), 'objectType' => $stock->getObjectType()));
        
        //Compare with all stocks found and return the first with the same attributes (except quantity)
        foreach ($stocksFound as $s) {
            if ($stock->equals($s))
            {
                return $s;
            }
        }
        
        //If not found an equal stock return null
        return null;
    }

}