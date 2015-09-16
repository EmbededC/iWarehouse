<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\Location;
use CB\WarehouseBundle\Form\LocationType;

/**
 * Location controller.
 *
 * @Route("/location")
 */
class LocationController extends Controller
{

    /**
     * Lists all Location entities.
     *
     * @Route("/", name="location")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:Location')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Show Warehouse map
     * Fixed url must be at top of page, because the program 
     * evaluate any data received as location_id when showAction arrives.
     *
     * @Route("/map/{id}", name="location_map")
     * @Template("CBWarehouseBundle:Location:map.html.twig")
     */
    public function mapAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $containerEntities = $em->getRepository('CBWarehouseBundle:Location')->findAllJoinedToContainer();
        $allAislesEntities = $em->getRepository('CBWarehouseBundle:Location')->findMaxXandYbyAisle(0);
        $maxXmaxYEntities = $em->getRepository('CBWarehouseBundle:Location')->findMaxXandYbyAisle($id);

        return array(
            'allAislesEntities' => $allAislesEntities,
            'maxXmaxYEntities' => $maxXmaxYEntities,
            'containerEntities' => $containerEntities,
            'aisleId' => $id,
        );
    }
    
    /**
     * Show Warehouse map
     * Fixed url must be at top of page, because the program 
     * evaluate any data received as location_id when showAction arrives.
     *
     * @Route("/map/{aisleId}/{id}", name="location_map_detail")
     * @Template("CBWarehouseBundle:Location:map.html.twig")
     */
    public function mapDetailAction($aisleId, $id)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        
        $containerEntities = $em->getRepository('CBWarehouseBundle:Location')->findAllJoinedToContainer();
        $maxXmaxYEntities = $em->getRepository('CBWarehouseBundle:Location')->findMaxXandYbyAisle($aisleId);
        $allAislesEntities = $em->getRepository('CBWarehouseBundle:Location')->findMaxXandYbyAisle(0);
        $containerDetailEntities = $em->getRepository('CBWarehouseBundle:Container')->findDetailsByContainer($id);
        $containerStockEntities = $em->getRepository('CBWarehouseBundle:Stock')->findStockByContainer($id);

        return array(
            'allAislesEntities' => $allAislesEntities,
            'maxXmaxYEntities' => $maxXmaxYEntities,
            'containerEntities' => $containerEntities,
            'containerDetailEntities' => $containerDetailEntities,
            'containerStockEntities' => $containerStockEntities,
            'aisleId' => $aisleId,
        );       
        
    }    
    
    /**
     * Creates a new Location entity.
     *
     * @Route("/", name="location_create")
     * @Method("POST")
     * @Template("CBWarehouseBundle:Location:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Location();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('location_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Location entity.
    *
    * @param Location $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Location $entity)
    {
        $form = $this->createForm(new LocationType(), $entity, array(
            'action' => $this->generateUrl('location_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Location entity.
     *
     * @Route("/new", name="location_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Location();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Location entity.
     *
     * @Route("/{id}", name="location_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Location')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Location entity.
     *
     * @Route("/{id}/edit", name="location_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Location')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
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
    * Creates a form to edit a Location entity.
    *
    * @param Location $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Location $entity)
    {
        $form = $this->createForm(new LocationType(), $entity, array(
            'action' => $this->generateUrl('location_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Location entity.
     *
     * @Route("/{id}", name="location_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:Location:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Location')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Location entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('location_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Location entity.
     *
     * @Route("/{id}", name="location_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CBWarehouseBundle:Location')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Location entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('location'));
    }

    /**
     * Creates a form to delete a Location entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('location_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
}
