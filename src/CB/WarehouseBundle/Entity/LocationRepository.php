<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * LocationRepository
 *
 */
class LocationRepository extends EntityRepository
{
    public function findAllJoinedToContainerAndStock()
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT l.id, l.code, l.aisle, l.x, l.y, p.name as product_name, c.code as container_code, s.quantity, c.id as container_id '
                . 'FROM CBWarehouseBundle:Location l '
                . 'LEFT JOIN CBWarehouseBundle:Container c WITH c.location = l.id '
                . 'LEFT JOIN CBWarehouseBundle:Stock s WITH s.objectId = c.id '
                . 'LEFT JOIN CBWarehouseBundle:Product p WITH p.id = s.product');

        return $query->getResult();
    }
    
    public function findAllJoinedToContainer()
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT l.id, l.code, l.aisle, l.x, l.y, c.code as container_code, c.id as container_id '
                . 'FROM CBWarehouseBundle:Location l '
                . 'LEFT JOIN CBWarehouseBundle:Container c WITH c.location = l.id ');

        return $query->getResult();
    }    
       
    public function findMaxXandYbyAisle($aisle)
    {
        $em = $this->getEntityManager();
        
        if ($aisle == 0)
        {
            $query = $em->createQuery('SELECT l.aisle, MAX(l.x) as x, MAX(l.y) as y '
                . 'FROM CBWarehouseBundle:Location l '
                . 'WHERE l.aisle != 0 '
                . 'GROUP BY l.aisle'   );
            
        }
        else
        {
            $query = $em->createQuery('SELECT l.aisle, MAX(l.x) as x, MAX(l.y) as y '
                . 'FROM CBWarehouseBundle:Location l '
                . 'WHERE l.aisle != 0 '
                . 'AND l.aisle = '. $aisle);
            
        }
        
        

        return $query->getResult();
        
    }   
    
}
