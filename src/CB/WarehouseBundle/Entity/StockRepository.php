<?php

namespace CB\WarehouseBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * StockRepository
 *
 */
class StockRepository extends EntityRepository
{
        
    /**
     * Gets the first stock that has the same attributes (except quantity) that
     * the stock passed as a parameter in the same location
     * 
     * @return \CB\WarehouseBundle\Entity\Stock or null if not found
     */
    public function findEqualInSameLocation(\CB\WarehouseBundle\Entity\Stock $stock)
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
    
    public function findAllJoinedToLocationAndContainer()
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT s.id, s.quantity, p.name as product_name, l.code as location_code, c.code as container_code, lc.code as container_location_code '
                . 'FROM CBWarehouseBundle:Stock s ' 
                . 'LEFT JOIN CBWarehouseBundle:Location l WITH l.id = s.objectId '
                . 'LEFT JOIN CBWarehouseBundle:Container c WITH c.id = s.objectId ' 
                . 'LEFT JOIN CBWarehouseBundle:Location lc WITH lc.id = c.location ' 
                . 'LEFT JOIN CBWarehouseBundle:Product p WITH p.id = s.product');

        return $query->getResult();
        
        //->add('from', 'NameBundle:Entity1 nb1 JOIN NameBundle:Entity2 nb2 WITH nb1.id = nb2.id')
        
        
//        $rsm = new ResultSetMapping();
//        $rsm->addEntityResult('CBWarehouseBundle:Stock', 's');
//        $rsm->addFieldResult('s', 'id', 'id');
//        $rsm->addFieldResult('s', 'quantity', 'quantity');
//        $rsm->addJoinedEntityResult('CBWarehouseBundle:Location' , 'l', 's', 'container');
//        $rsm->addFieldResult('l', 'location_code', 'code');
//
//        
//        $query = $em->createNativeQuery(
//            'SELECT s.id, s.quantity, l.code as location_code
//            FROM Stock s
//            LEFT JOIN Location l ON l.id = s.objectId',
//            //LEFT JOIN Container c ON c.id = s.objectId',
//            //LIMIT 0 , 30
//            $rsm
//        );
//        
//        return $query->getResult();

        
//        $rsm = new ResultSetMappingBuilder($em);
//        $rsm->addRootEntityFromClassMetadata('CBWarehouseBundle:Stock', 's');
//        //$rsm->addJoinedEntityFromClassMetadata('CBWarehouseBundle:Location', 'l', 's', 'id', array('id' => 'location_id', 'createdDate' => 'locationCreatedDate', 'updatedDate' => 'locationUpdatedDate'));
//        //$rsm->addJoinedEntityFromClassMetadata('CBWarehouseBundle:Container', 'l', 's', 'container', array('id' => 'objectId'));
//
//        
//        $query = $em->createNativeQuery(
//            'SELECT s.*
//            FROM Stock s
//            LEFT JOIN Location l ON l.id = s.objectId',
//            //LEFT JOIN Container c ON c.id = s.objectId',
//            //LIMIT 0 , 30
//            $rsm
//        );
//
//        return $query->getResult();
        
        
//        //Example
//        $rsm = new ResultSetMapping;
//        $rsm->addEntityResult('User', 'u');
//        $rsm->addFieldResult('u', 'id', 'id');
//        $rsm->addFieldResult('u', 'name', 'name');
//        $rsm->addJoinedEntityResult('Address' , 'a', 'u', 'address');
//        $rsm->addFieldResult('a', 'address_id', 'id');
//        $rsm->addFieldResult('a', 'street', 'street');
//        $rsm->addFieldResult('a', 'city', 'city');
//
//        $sql = 'SELECT u.id, u.name, a.id AS address_id, a.street, a.city FROM users u ' .
//               'INNER JOIN address a ON u.address_id = a.id WHERE u.name = ?';
//        $query = $this->_em->createNativeQuery($sql, $rsm);
//        $query->setParameter(1, 'romanb');
//
//        $users = $query->getResult();
    }
    
    public function findStockByContainer($id)
    {
        $em = $this->getEntityManager();
        
        $query = $em->createQuery('SELECT s.quantity, p.name, s.id '
                . 'FROM CBWarehouseBundle:Stock s '                 
                . 'LEFT JOIN CBWarehouseBundle:Container c WITH c.id = s.objectId ' 
                . 'LEFT JOIN CBWarehouseBundle:Product p WITH p.id = s.product '
                . 'WHERE c.id =' . $id);

        return $query->getResult();
    }
    
}