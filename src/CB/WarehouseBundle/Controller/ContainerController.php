<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\Container;
use CB\WarehouseBundle\Form\ContainerType;

/**
 * Container controller.
 *
 * @Route("/container")
 */
class ContainerController extends Controller
{

    /**
     * Lists all Container entities.
     *
     * @Route("/", name="container")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:Container')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Container entity.
     *
     * @Route("/", name="container_create")
     * @Method("POST")
     * @Template("CBWarehouseBundle:Container:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Container();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('container_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Container entity.
    *
    * @param Container $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Container $entity)
    {
        $form = $this->createForm(new ContainerType(), $entity, array(
            'action' => $this->generateUrl('container_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Container entity.
     *
     * @Route("/new", name="container_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Container();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Container entity.
     *
     * @Route("/{id}", name="container_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Container')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Container entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Container entity.
     *
     * @Route("/{id}/edit", name="container_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Container')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Container entity.');
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
    * Creates a form to edit a Container entity.
    *
    * @param Container $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Container $entity)
    {
        $form = $this->createForm(new ContainerType(), $entity, array(
            'action' => $this->generateUrl('container_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Container entity.
     *
     * @Route("/{id}", name="container_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:Container:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Container')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Container entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('container_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Container entity.
     *
     * @Route("/{id}", name="container_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CBWarehouseBundle:Container')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Container entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('container'));
    }
    
    /**
     * Displays a form to edit an existing Container entity.
     *
     * @Route("/{id}/move", name="container_move")
     * @Method("GET")
     * @Template()
     */
    public function editLocationAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Container')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Container entity.');
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
     * Creates a form to delete a Container entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('container_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
    * Creates a form to edit a Container entity.
    *
    * @param Stock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditLocationForm(Stock $entity)
    {
        $form = $this->createForm(new ContainerLocationType(), $entity, array(
            'action' => $this->generateUrl('container_location_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
}
