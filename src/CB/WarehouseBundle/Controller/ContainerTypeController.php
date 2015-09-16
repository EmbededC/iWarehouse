<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\ContainerType;
use CB\WarehouseBundle\Form\ContainerTypeType;

/**
 * ContainerType controller.
 *
 * @Route("/containertype")
 */
class ContainerTypeController extends Controller
{

    /**
     * Lists all ContainerType entities.
     *
     * @Route("/", name="containertype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:ContainerType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ContainerType entity.
     *
     * @Route("/", name="containertype_create")
     * @Method("POST")
     * @Template("CBWarehouseBundle:ContainerType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ContainerType();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('containertype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ContainerType entity.
    *
    * @param ContainerType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ContainerType $entity)
    {
        $form = $this->createForm(new ContainerTypeType(), $entity, array(
            'action' => $this->generateUrl('containertype_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ContainerType entity.
     *
     * @Route("/new", name="containertype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ContainerType();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ContainerType entity.
     *
     * @Route("/{id}", name="containertype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ContainerType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContainerType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ContainerType entity.
     *
     * @Route("/{id}/edit", name="containertype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ContainerType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContainerType entity.');
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
    * Creates a form to edit a ContainerType entity.
    *
    * @param ContainerType $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContainerType $entity)
    {
        $form = $this->createForm(new ContainerTypeType(), $entity, array(
            'action' => $this->generateUrl('containertype_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ContainerType entity.
     *
     * @Route("/{id}", name="containertype_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:ContainerType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ContainerType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContainerType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('containertype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ContainerType entity.
     *
     * @Route("/{id}", name="containertype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CBWarehouseBundle:ContainerType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContainerType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('containertype'));
    }

    /**
     * Creates a form to delete a ContainerType entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('containertype_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
