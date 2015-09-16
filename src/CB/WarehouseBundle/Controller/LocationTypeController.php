<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\LocationType;
use CB\WarehouseBundle\Form\LocationTypeType;

/**
 * LocationType controller.
 *
 * @Route("/locationtype")
 */
class LocationTypeController extends Controller
{

    /**
     * Lists all LocationType entities.
     *
     * @Route("/", name="locationtype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:LocationType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new LocationType entity.
     *
     * @Route("/", name="locationtype_create")
     * @Method("POST")
     * @Template("CBWarehouseBundle:LocationType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new LocationType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('locationtype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a LocationType entity.
    *
    * @param LocationType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(LocationType $entity)
    {
        $form = $this->createForm(new LocationTypeType(), $entity, array(
            'action' => $this->generateUrl('locationtype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new LocationType entity.
     *
     * @Route("/new", name="locationtype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new LocationType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a LocationType entity.
     *
     * @Route("/{id}", name="locationtype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:LocationType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocationType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing LocationType entity.
     *
     * @Route("/{id}/edit", name="locationtype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:LocationType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocationType entity.');
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
    * Creates a form to edit a LocationType entity.
    *
    * @param LocationType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(LocationType $entity)
    {
        $form = $this->createForm(new LocationTypeType(), $entity, array(
            'action' => $this->generateUrl('locationtype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing LocationType entity.
     *
     * @Route("/{id}", name="locationtype_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:LocationType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:LocationType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocationType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('locationtype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a LocationType entity.
     *
     * @Route("/{id}", name="locationtype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CBWarehouseBundle:LocationType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LocationType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('locationtype'));
    }

    /**
     * Creates a form to delete a LocationType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('locationtype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
