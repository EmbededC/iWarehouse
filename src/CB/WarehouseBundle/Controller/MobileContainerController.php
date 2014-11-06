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
 * @Route("/mobile/container")
 */
class MobileContainerController extends Controller
{

    /**
     * Main page - Show a textbox to search container or create a new 
     * and a lists of containers.
     *
     * @Route("/", name="container_mobile")
     * @Method("GET")
     * @Template("CBWarehouseBundle:Mobile:Container/index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $containers = $em->getRepository('CBWarehouseBundle:Container')->findAllJoinedToLocation();

        return array(
            'containers' => $containers,
        );
    }
    
     /**
     * MAIN PAGE
     * 
     * If {code} exist, show it and allow modify/delete.
     * If {code} doesnt exist, allow to create a new container with code used.
     *
     * @Route("/{code}",defaults={"action"=null}, name="container_mobile_container")
     * @Route("/{code}/{action}", name="container_mobile_container_updated")
     * @Method("GET")
     * @Template("CBWarehouseBundle:Mobile:Container/container.html.twig")
     */
    public function showAction($code, $action)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CBWarehouseBundle:Container')->findOneBy(array('code' => $code));
        
        if ($entity) 
        {
            $stock = $em->getRepository('CBWarehouseBundle:Stock')->findStockByContainer($entity->getId());
            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($entity->getId());

            return array(
                'entity'      => $entity,
                'form'        => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'action'      => $action,
                'stock'       => $stock,
                'containerId' => $entity->getId(),
            );
        }
        else
        {

           $entity = new Container();
           $entity->setCode($code);
           $form   = $this->createCreateForm($entity);

           return array(
               'entity' => $entity,
               'form'   => $form->createView(),
               'action'      => 'new',
           );
        }
    } 
    
    /**
    * CREATE ACTION
    * 
    * Creates a form to create a Container entity.
    *
    * @param Container $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Container $entity)
    {
        $form = $this->createForm(new ContainerType(), $entity, array(
            'action' => $this->generateUrl('container_mobile_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a new Container entity.
     *
     * @Route("/", name="container_mobile_create")
     * @Method("POST")
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

            return $this->redirect($this->generateUrl('container_mobile_container', array('code' => $entity->getCode())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    
    /**
    * EDIT/SHOW ACTION
    * 
    * Creates a form to edit/show a Container entity.
    *
    * @param Container $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Container $entity)
    {
        $form = $this->createForm(new ContainerType(), $entity, array(
            'action' => $this->generateUrl('container_mobile_update', array('code' => $entity->getCode())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }    
    
    /**
     * Edits an existing Container entity.
     *
     * @Route("/{code}", name="container_mobile_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $code)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CBWarehouseBundle:Container')->findOneBy(array('code' => $code));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Container entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getId());
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('container_mobile_container_updated', array('code' => $entity->getCode(), 'action' => 'updated')));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * DELETE ACTION
     * 
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

        return $this->redirect($this->generateUrl('container_mobile'));
    }    

}