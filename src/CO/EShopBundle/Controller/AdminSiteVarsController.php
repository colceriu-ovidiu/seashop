<?php

namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\SiteVar;
use CO\EShopBundle\Form\SiteVarType;

/**
 * SiteVars controller.
 *
 * @Route("/admin/sitevars")
 */
class AdminSiteVarsController extends Controller
{
	
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_sitevars")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('COEShopBundle:SiteVar')->findAll();

        return array(
            'entities' => $entities,
        );
    }
		
    /**
     * Displays a form to edit an existing SiteVars entity.     
		 *     
		 * @Route("/{id}/edit", name="admin_sitevars_edit")     
		 * @Template()    
		 */    
		public function editAction($id)    {		
				$em = $this->getDoctrine()->getManager();			
				$entity = $em->getRepository('COEShopBundle:SiteVar')->find($id);			
				if (!$entity) {					
					throw $this->createNotFoundException('Unable to find SiteVar entity.');			
				}		
        $editForm = $this->createForm(new SiteVarType(), $entity);		
				$request = $this->getRequest();        
				if ($request->getMethod() == 'POST') {        	
					$editForm->bindRequest($request);					
					if ($editForm->isValid()) {						
						$em = $this->getDoctrine()->getManager();						
						$em->persist($entity);						
						$em->flush();
						
						$this->get('session')->setFlash('notice', 'SiteVar '.$entity->getName().' a fost modificata');												
						return $this->redirect($this->generateUrl('admin_sitevars'));															
					}
		}

        return array(
            'entity'      => $entity,
						'id'      => $id,
            'edit_form'   => $editForm->createView()
        );
    }		
	
}

