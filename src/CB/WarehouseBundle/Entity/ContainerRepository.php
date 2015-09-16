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
}
