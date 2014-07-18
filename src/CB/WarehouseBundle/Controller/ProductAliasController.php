<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\WarehouseBundle\Entity\ProductAlias;
use CB\WarehouseBundle\Form\ProductAliasType;

/**
 * ProductAlias controller.
 *
 * @Route("/productalias")
 */
class ProductAliasController extends Controller
{

    /**
     * Lists all ProductAlias entities.
     *
     * @Route("/", name="productalias")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:ProductAlias')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ProductAlias entity.
     *
     * @Route("/", name="productalias_create")
     * @Method("POST")
     * @Template("CBWarehouseBundle:ProductAlias:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ProductAlias();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productalias_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a ProductAlias entity.
    *
    * @param ProductAlias $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProductAlias $entity)
    {
        $form = $this->createForm(new ProductAliasType(), $entity, array(
            'action' => $this->generateUrl('productalias_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductAlias entity.
     *
     * @Route("/new", name="productalias_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProductAlias();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProductAlias entity.
     *
     * @Route("/{id}", name="productalias_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductAlias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductAlias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProductAlias entity.
     *
     * @Route("/{id}/edit", name="productalias_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductAlias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductAlias entity.');
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
    * Creates a form to edit a ProductAlias entity.
    *
    * @param ProductAlias $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProductAlias $entity)
    {
        $form = $this->createForm(new ProductAliasType(), $entity, array(
            'action' => $this->generateUrl('productalias_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ProductAlias entity.
     *
     * @Route("/{id}", name="productalias_update")
     * @Method("PUT")
     * @Template("CBWarehouseBundle:ProductAlias:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:ProductAlias')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductAlias entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('productalias_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProductAlias entity.
     *
     * @Route("/{id}", name="productalias_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CBWarehouseBundle:ProductAlias')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductAlias entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('productalias'));
    }

    /**
     * Creates a form to delete a ProductAlias entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productalias_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
