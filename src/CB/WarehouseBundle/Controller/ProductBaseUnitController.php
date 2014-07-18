<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\ProductBaseUnit;
use CB\WarehouseBundle\Form\ProductBaseUnitType;

/**
 * ProductBaseUnit controller.
 *
 * @Route("/productbaseunit")
 */
class ProductBaseUnitController extends Controller
{

    /**
     * Lists all ProductBaseUnit entities.
     *
     * @Route("/", name="productbaseunit")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:ProductBaseUnit')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ProductBaseUnit entity.
     *
     * @Route("/", name="productbaseunit_create")
     * @Method("POST")
     * @Template("CBWarehouseBundle:ProductBaseUnit:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProductBaseUnit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productbaseunit_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ProductBaseUnit entity.
    *
    * @param ProductBaseUnit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProductBaseUnit $entity)
    {
        $form = $this->createForm(new ProductBaseUnitType(), $entity, array(
            'action' => $this->generateUrl('productbaseunit_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductBaseUnit entity.
     *
     * @Route("/new", name="productbaseunit_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProductBaseUnit();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProductBaseUnit entity.
     *
     * @Route("/{id}", name="productbaseunit_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductBaseUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductBaseUnit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProductBaseUnit entity.
     *
     * @Route("/{id}/edit", name="productbaseunit_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductBaseUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductBaseUnit entity.');
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
    * Creates a form to edit a ProductBaseUnit entity.
    *
    * @param ProductBaseUnit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProductBaseUnit $entity)
    {
        $form = $this->createForm(new ProductBaseUnitType(), $entity, array(
            'action' => $this->generateUrl('productbaseunit_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ProductBaseUnit entity.
     *
     * @Route("/{id}", name="productbaseunit_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:ProductBaseUnit:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductBaseUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductBaseUnit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('productbaseunit_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProductBaseUnit entity.
     *
     * @Route("/{id}", name="productbaseunit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CBWarehouseBundle:ProductBaseUnit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductBaseUnit entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('productbaseunit'));
    }

    /**
     * Creates a form to delete a ProductBaseUnit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productbaseunit_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
