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
        
        $query = $em->createQuery('SELECT l.id, l.code, p.name as product_name, c.code as container_code, s.quantity '
                . 'FROM CBWarehouseBundle:Location l '
                . 'LEFT JOIN CBWarehouseBundle:Stock s WITH s.objectId = l.id '
                . 'LEFT JOIN CBWarehouseBundle:Container c WITH c.location = l.id '
                . 'LEFT JOIN CBWarehouseBundle:Product p WITH p.id = s.product');

        return $query->getResult();
    }
}
