<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\Stock;
use CB\WarehouseBundle\Form\StockType;
use CB\WarehouseBundle\Form\StockLocationType;
use CB\WarehouseBundle\Form\StockQuantityType;

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
            
            //Check if there is another stock into the same container or location with the same attributes
            //if exists modify the found stock adding the new quantity
            $stockToMerge = $em->getRepository('CBWarehouseBundle:Stock')->findEqual($entity);
            
            if ($stockToMerge)
            {
                //Add stock to existing stock
                $stockToMerge->setQuantity($stockToMerge->getQuantity() + $entity->getQuantity());
                $em->persist($stockToMerge);
                $em->flush();
            }
            else
            {            
                //Create a new stock
                $em->persist($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('stock_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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
            
            $em->flush();

            return $this->redirect($this->generateUrl('stock_edit', array('id' => $id)));
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

        //if ($editForm->isValid()) {
            
            $em->flush();

            return $this->redirect($this->generateUrl('stock_edit_qtty', array('id' => $id)));
        //}

//        return array(
//            'entity'      => $entity,
//            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        );
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

        //if ($editForm->isValid()) {
            
            $em->flush();

            return $this->redirect($this->generateUrl('stock_move', array('id' => $id)));
        //}

//        return array(
//            'entity'      => $entity,
//            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        );
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

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('stock'));
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
}
