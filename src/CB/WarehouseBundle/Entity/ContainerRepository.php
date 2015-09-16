<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * ContainerRepository
 *
 */
class ContainerRepository extends EntityRepository
{
    public function findAllJoinedToLocationAndStock()
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT c.id, c.code, p.name as product_name, l.code as location_code, s.quantity '
                . 'FROM CBWarehouseBundle:Container c '
                . 'LEFT JOIN CBWarehouseBundle:Stock s WITH s.objectId = c.id '
                . 'LEFT JOIN CBWarehouseBundle:Location l WITH c.location = l.id '
                . 'LEFT JOIN CBWarehouseBundle:Product p WITH p.id = s.product');

        return $query->getResult();
    }
    
    public function findAllJoinedToLocation()
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT c.id, c.code, l.code as location_code '
                . 'FROM CBWarehouseBundle:Container c '
                . 'LEFT JOIN CBWarehouseBundle:Location l WITH c.location = l.id ');

        return $query->getResult();
    }    
    
    public function findDetailsByContainer($containerId)
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT c.id, c.code, l.code as location_code '
                . 'FROM CBWarehouseBundle:Container c '
                . 'LEFT JOIN CBWarehouseBundle:Location l WITH c.location = l.id '
                . 'WHERE c.id = ' . $containerId);

        return $query->getResult();
         
    }
    
    public function findContainerByStockId($stockId)
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT c.id, c.code '
                . 'FROM CBWarehouseBundle:Stock s '                 
                . 'LEFT JOIN CBWarehouseBundle:Container c WITH c.id = s.objectId ' 
                . 'WHERE s.id =' . $stockId);

        return $query->getResult();
         
    }    
        
}
