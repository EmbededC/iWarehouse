<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\ProductPresentations;
use CB\WarehouseBundle\Form\ProductPresentationsType;

/**
 * ProductPresentations controller.
 *
 * @Route("/productpresentations")
 */
class ProductPresentationsController extends Controller
{

    /**
     * Lists all ProductPresentations entities.
     *
     * @Route("/", name="productpresentations")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:ProductPresentations')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ProductPresentations entity.
     *
     * @Route("/", name="productpresentations_create")
     * @Method("POST")
     * @Template("CBWarehouseBundle:ProductPresentations:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProductPresentations();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productpresentations_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ProductPresentations entity.
    *
    * @param ProductPresentations $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProductPresentations $entity)
    {
        $form = $this->createForm(new ProductPresentationsType(), $entity, array(
            'action' => $this->generateUrl('productpresentations_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductPresentations entity.
     *
     * @Route("/new", name="productpresentations_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProductPresentations();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProductPresentations entity.
     *
     * @Route("/{id}", name="productpresentations_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductPresentations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductPresentations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProductPresentations entity.
     *
     * @Route("/{id}/edit", name="productpresentations_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductPresentations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductPresentations entity.');
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
    * Creates a form to edit a ProductPresentations entity.
    *
    * @param ProductPresentations $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProductPresentations $entity)
    {
        $form = $this->createForm(new ProductPresentationsType(), $entity, array(
            'action' => $this->generateUrl('productpresentations_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ProductPresentations entity.
     *
     * @Route("/{id}", name="productpresentations_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:ProductPresentations:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductPresentations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductPresentations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('productpresentations_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProductPresentations entity.
     *
     * @Route("/{id}", name="productpresentations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CBWarehouseBundle:ProductPresentations')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductPresentations entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('productpresentations'));
    }

    /**
     * Creates a form to delete a ProductPresentations entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productpresentations_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
