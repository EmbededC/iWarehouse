<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\Stock;
use CB\WarehouseBundle\Entity\EventLog;
use CB\WarehouseBundle\Form\StockType;
use CB\WarehouseBundle\Form\StockLocationType;
use CB\WarehouseBundle\Form\StockQuantityType;
use CB\WarehouseBundle\Form\StockSplitType;

/**
 * Stock controller.
 *
 * @Route("/stock")
 */
class StockController extends Controller
{
    /**
     * Lists all Stock entities.
     *
     * @Route("/", name="stock")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:Stock')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Creates a new Stock entity.
     *
     * @Route("/", name="stock_create")
     * @Method("POST")
     * @Template("CBWarehouseBundle:Stock:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Stock();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $this->CreateStockMerging($em, $entity, true, 'STOCK_CREATE', 'STOCK_RECEIVED', 'CREATE');
        }
        
        return $this->redirect($this->generateUrl('default_index'));
    }

    /**
    * Creates a form to create a Stock entity.
    *
    * @param Stock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Stock $entity)
    {
        $form = $this->createForm(new StockType(), $entity, array(
            'action' => $this->generateUrl('stock_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Stock entity.
     *
     * @Route("/new", name="stock_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Stock();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Stock entity.
     *
     * @Route("/{id}", name="stock_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Stock entity.
     *
     * @Route("/{id}/edit", name="stock_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
            'action' => $this->generateUrl('stock_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
   /**
    * Creates a form to edit a Stock entity.
    *
    * @param Stock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditQuantityForm(Stock $entity)
    {
        $form = $this->createForm(new StockQuantityType(), $entity, array(
            'action' => $this->generateUrl('stock_quantity_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
   /**
    * Creates a form to edit a Stock entity.
    *
    * @param Stock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditLocationForm(Stock $entity)
    {
        $form = $this->createForm(new StockLocationType(), $entity, array(
            'action' => $this->generateUrl('stock_location_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
    * Creates a form to edit a Stock entity.
    *
    * @param Stock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditSplitForm(Stock $entity)
    {
        $form = $this->createForm(new StockSplitType(), $entity, array(
            'action' => $this->generateUrl('stock_split', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Stock entity.
     *
     * @Route("/{id}", name="stock_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:Stock:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            //$this->CreateStockMerging($em, $entity, true, 'STOCK_MODIFY', 'STOCK_RECEIVED', 'UPDATE');

            //$em->flush();
            
            $em->persist($this->AddEventLog($em, 'desc', 'STOCK_MODIFY', 'STOCK_RECEIVED', 'UPDATE', $entity, $entity->getId(), 0));
            $em->flush();
            
            return $this->redirect($this->generateUrl('default_index'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Edits an existing Stock entity.
     *
     * @Route("/{id}/quantity", name="stock_quantity_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:Stock:edit.html.twig")
     */
    public function updateQuantityAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditQuantityForm($entity);
        $editForm->handleRequest($request);
        
        //$this->CreateStockMerging($em, $entity, true, 'STOCK_INCDEC', 'STOCK_RECEIVED', 'UPDATE');
        //$em->flush();
        
        $em->persist($this->AddEventLog($em, 'desc', 'STOCK_INCDEC', 'STOCK_RECEIVED', 'UPDATE', $entity, $entity->getId(), 0));
        $em->flush();
        
        return $this->redirect($this->generateUrl('default_index'));        
    }
    
    /**
     * Edits an existing Stock entity.
     *
     * @Route("/{id}/location", name="stock_location_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:Stock:edit.html.twig")
     */
    public function updateLocationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditLocationForm($entity);
        $editForm->handleRequest($request);
        
        $this->CreateStockMerging($em, $entity, true, 'STOCK_MOVE', 'STOCK_RECEIVED', 'UPDATE');
        //{
        //    //If merge, then delete origin stock
        //    $em->remove($entity);
        //    $em->flush();
        //}
        
        //$em->flush();

        //$em->persist($this->AddEventLog($em, 'desc', 'STOCK_MOVE', 'STOCK_RECEIVED', 'UPDATE', $entity, $entity->getId(), 0));
        //$em->flush();

        return $this->redirect($this->generateUrl('default_index'));
    }
    
    /**
     * Edits an existing Stock entity and splits.
     *
     * @Route("/{id}/split", name="stock_split_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:Stock:edit.html.twig")
     */
    public function splitAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }
        $oldQuantity = $entity->getQuantity();
        $oldBaseQuantity = $entity->getBaseQuantity();
        $oldObjectId = $entity->getObjectId();
        $oldObjectType = $entity->getObjectType();
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditSplitForm($entity);
        $editForm->handleRequest($request);

        $this->CreateStockMerging($em, $entity, true, 'STOCK_SPLIT', 'STOCK_PICKING', 'UPDATE');
        //$em->persist($this->AddEventLog($em, 'desc', 'STOCK_SPLIT', 'STOCK_PICKING', 'UPDATE', $entity, $entity->getId(), 0));
        
        $newEntity = new Stock();
        $newEntity->setBestBeforeDate($entity->getBestBeforeDate());
        $newEntity->setExpiryDate($entity->getExpiryDate());
        $newEntity->setLot($entity->getLot());
        $newEntity->setObjectId($oldObjectId);
        $newEntity->setObjectType($oldObjectType);
        $newEntity->setPresentation($entity->getPresentation());
        $newEntity->setProduct($entity->getProduct());
        $newEntity->setProductionDate($entity->getProductionDate());
        $newEntity->setRecivedDate($entity->getRecivedDate());
        $newEntity->setSn($entity->getSn());
        $newEntity->setUpdatedDate($entity->getUpdatedDate());
        $newEntity->setQuantity($oldQuantity - $entity->getQuantity() );
        $newEntity->setBaseQuantity($oldBaseQuantity - $entity->getBaseQuantity() );
        $em->persist($newEntity);
        
        $this->CreateStockMerging($em, $newEntity, true, 'STOCK_SPLIT', 'STOCK_PICKING', 'CREATE');
        
        //$em->flush();
        
        //$em->persist($this->AddEventLog($em, 'desc', 'STOCK_SPLIT', 'STOCK_PICKING', 'CREATE', $newEntity, $newEntity->getId(), 0));
        //$em->flush();

        return $this->redirect($this->generateUrl('default_index'));
    }
    
    /**
     * Deletes a Stock entity.
     *
     * @Route("/{id}", name="stock_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Stock entity.');
            }

            $em->persist($this->AddEventLog($em, 'desc', 'STOCK_DELETE', 'STOCK_SEND', 'DELETE', $entity, $entity->getId(), 0));
            $em->flush();
            
            $em->remove($entity);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('default_index'));
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
            ->setAction($this->generateUrl('stock_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Displays a form to edit an existing Stock entity.
     *
     * @Route("/{id}/qtty", name="stock_edit_qtty")
     * @Method("GET")
     * @Template()
     */
    public function editQuantityAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $editForm = $this->createEditQuantityForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Displays a form to edit an existing Stock entity.
     *
     * @Route("/{id}/move", name="stock_move")
     * @Method("GET")
     * @Template()
     */
    public function editLocationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $editForm = $this->createEditLocationForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Displays a form to edit an existing Stock entity.
     *
     * @Route("/{id}/split", name="stock_split")
     * @Method("GET")
     * @Template()
     */
    public function editSplitAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Stock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Stock entity.');
        }

        $editForm = $this->createEditSplitForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
}
