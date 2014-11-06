<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\Stock;
use CB\WarehouseBundle\Entity\Container;
use CB\WarehouseBundle\Entity\EventLog;
use CB\WarehouseBundle\Form\StockType;
use CB\WarehouseBundle\Form\StockLocationType;
use CB\WarehouseBundle\Form\StockQuantityType;
use CB\WarehouseBundle\Form\StockSplitType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Stock controller.
 *
 * @Route("/mobile/stock")
 */
class MobileStockController extends Controller
{   
    
    /**
     * MAIN PAGE
     *
     * @Route("/{containerId}",defaults={"id"=null}, name="stock_mobile_create")
     * @Route("/{containerId}/{id}", name="stock_mobile_edit")
     * @Method("GET")
     * @Template("CBWarehouseBundle:Mobile:Stock/edit.html.twig")
     * 
     * @param $id stock id to edit. It could be null, if we're going to created a new stock.
     * @param $containerId ContainerId where stock will be created/edited.
     */
    public function indexAction($containerId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Stock();
        $action;
        
        if($id != null)
        {
            //Stock update...
            $action = "update";
            
            $stock = $em->getRepository('CBWarehouseBundle:Stock')->find($id);
            
            //Get container data and create EditForm
            $container = $em->getRepository('CBWarehouseBundle:Container')->find($containerId);
            $editForm = $this->createEditForm($stock);

            return array(
                'entity'      => $entity,
                'form'        => $editForm->createView(),
                'action'      => $action,
                'containerCode'   => $container->getCode(),
                'containerId'     => $container->getId(),
            );
        }
        else
        {
            //Stock creation..
            $action = "create";
            
            //Get container data and create CreateForm
            $container = $em->getRepository('CBWarehouseBundle:Container')->find($containerId);
            $form = $this->createCreateForm($entity,$container->getId());
            
            return array(
               'entity' => $entity,
               'form'   => $form->createView(),
               'action' => $action,
               'containerCode'   => $container->getCode(),
               'containerId'     => $container->getId(),
           );
            
        }       
    }

    /**
    * Creates a form to create a Stock entity.
    *
    * @param Stock $entity The entity
    * @param $containerId ContainerId where stock will be created.
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Stock $entity, $containerId)
    {
        $form = $this->createForm(new StockType(), $entity, array(
            'action' => $this->generateUrl('stock_mobile_creation', array('containerId'=> $containerId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    
    /**
     * Creates a new Stock entity.
     *
     * @Route("/{containerId}", name="stock_mobile_creation")
     * @Method("POST")
     */
    public function createAction(Request $request,$containerId)
    {
        $entity = new Stock();
        $form = $this->createCreateForm($entity, $containerId);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        $container = $em->getRepository('CBWarehouseBundle:Container')->find($containerId);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $this->CreateStockMerging($em, $entity, true, 'STOCK_CREATE', 'STOCK_RECEIVED', 'CREATE');
        }
        
        return $this->redirect($this->generateUrl('container_mobile_container_updated', array('code' => $container->getCode(), 'action' => 'stockCreated')));
    }  
    
    private function CreateStockMerging($em, $entity, $merge, $event, $reason, $eventType)
    {
        //Check if there is another stock into the same container or location with the same attributes
        //if exists modify the found stock adding the new quantity
        $stockToMerge = $em->getRepository('CBWarehouseBundle:Stock')->findEqualInSameLocation($entity);

        //If we find an equal stock into the destination of the updated or created stock => we merge the two stocks
        if ($stockToMerge && $merge)
        {
            //Add stock to existing stock
            $stockToMerge->setQuantity($stockToMerge->getQuantity() + $entity->getQuantity());
            $stockToMerge->setBaseQuantity($stockToMerge->getBaseQuantity() + $entity->getBaseQuantity());
            $em->persist($stockToMerge);
            //$em->flush();

            $em->persist($this->AddEventLog($em, 'desc', 'STOCK_INCDEC', 'STOCK_RECEIVED', 'UPDATE', $stockToMerge, $stockToMerge->getId(), 0));
            //$em->flush();
            
            //If the stock is moved and is merged with a stock into the destination => delete the origin stock
            if ($event = 'STOCK_MOVE')
            {
                $em->remove($entity);
                //$em->flush();
            }
            
            //Make the changes efective
            $em->flush();
            
            return true;
        }
        else
        {
            //Persist the changes
            $em->persist($entity);
            
            //If the $entity is new then flush to get the entity id
            if ($eventType = 'CREATE')
            {
                $em->flush();
            }

            $em->persist($this->AddEventLog($em, 'desc', $event, $reason, $eventType, $entity, $entity->getId(), 0));
            
            //Make the changes efective
            $em->flush();
            
            return false;
        }
    }    


   /**
    * Creates a form to edit a Stock entity.
    *
    * @param Stock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Stock $entity)
    {
        $form = $this->createForm(new StockType(), $entity, array(
            'action' => $this->generateUrl('stock_mobile_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Stock entity.
     *
     * @Route("/{id}", name="stock_mobile_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:Mobile:Stock/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }
        
        $container = $em->getRepository('CBWarehouseBundle:Container')->find($entity->getObjectId());
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
                       
            $em->persist($this->AddEventLog($em, 'desc', 'STOCK_MODIFY', 'STOCK_RECEIVED', 'UPDATE', $entity, $entity->getId(), 0));
            $em->flush();
            
            return $this->redirect($this->generateUrl('container_mobile_container_updated', array('code' => $container->getCode(), 'action' => 'stockUpdated')));
        }
        else
        {
            return array(
                'entity'      => $entity,
                'form'        => $editForm->createView(),
                'action'      => 'updateError',
                'container'   => $container->getCode(),
             );
        }
    }
    
        
    /**
     * Deletes a Stock entity.
     *
     * @Route("/{containerId}/{id}/delete", name="stock_mobile_delete")
     * @Method("GET")
     */
    public function deleteAction($containerId, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $container = $em->getRepository('CBWarehouseBundle:Container')->find($containerId);

        $em->persist($this->AddEventLog($em, 'desc', 'STOCK_DELETE', 'STOCK_SEND', 'DELETE', $entity, $entity->getId(), 0));
        $em->flush();

        $em->remove($entity);
        $em->flush();
        
        
        return $this->redirect($this->generateUrl('container_mobile_container_updated', array('code' => $container->getCode(), 'action' => 'stockDeleted')));
    }

    /**
     * Creates a form to delete a Stock entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stock_mobile_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    private function AddEventLog($em, $description, $event, $reason, $eventType, $object, $objectId, $userId)
    {
        //Add log
        $log = new EventLog();
        $log->setCreatedAt(new \DateTime());
        $log->setDescription($description);
        $log->setEvent($em->getRepository('CBWarehouseBundle:Event')->findOneByCode($event));
        $log->setEventReason($em->getRepository('CBWarehouseBundle:EventReason')->findOneByCode($reason));
        $log->setEventType($em->getRepository('CBWarehouseBundle:EventType')->findOneByCode($eventType));
        $log->setObjectId($objectId);
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $log->setObject($serializer->serialize($object, 'json'));
        $log->setObjectType(get_class($object));
        $log->setUser($userId);
        return $log;
    }
}
