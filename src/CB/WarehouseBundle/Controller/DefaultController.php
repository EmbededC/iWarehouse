<?php

namespace CB\WarehouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CBWarehouseBundle:Stock')->findAllJoinedToLocationAndContainer();
        $locEntities = $em->getRepository('CBWarehouseBundle:Location')->findAllJoinedToContainerAndStock();
        $conEntities = $em->getRepository('CBWarehouseBundle:Container')->findAllJoinedToLocationAndStock();
        $provEntities = $em->getRepository('CBWarehouseBundle:Provider')->findAll();
        
        //\Doctrine\Common\Util\Debug::dump($entities);

        return array(
            'entities' => $entities,
            'locEntities' => $locEntities,
            'conEntities' => $conEntities,
            'provEntities' => $provEntities,
        );
    }
    
    /**
     * @Route("/reception")
     * @Template()
     */
    public function receptionAction()
    {
        $order = null;
        
        
    }
}
