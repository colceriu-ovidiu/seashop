<?php

namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\Page;
use CO\EShopBundle\Form\PageType;

/**
 * Category controller.
 *
 * @Route("/admin/pages")
 */
class AdminPagesController extends Controller
{
	
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_pages")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('COEShopBundle:Page')->findAll();

        return array(
            'entities' => $entities,
        );
    }
		
    /**
     * Displays a form to edit an existing Category entity.     
		 *     
		 * @Route("/{id}/edit", name="admin_pages_edit")     
		 * @Template()    
		 */    
		public function editAction($id)    {
				if ($id>0) {			
					$em = $this->getDoctrine()->getManager();			
					$entity = $em->getRepository('COEShopBundle:Page')->find($id);			
					if (!$entity) {					
						throw $this->createNotFoundException('Unable to find Page entity.');			
					}		
				} else {			
					$entity  = new Page();		
				}			
        		$editForm = $this->createForm(new PageType(), $entity);		
				$request = $this->getRequest();        
				if ($request->getMethod() == 'POST') {        	
					$editForm->bindRequest($request);					
					if ($editForm->isValid()) {						
						$em = $this->getDoctrine()->getEntityManager();						
						$em->persist($entity);						
						$em->flush();
						
						$this->get('session')->setFlash('notice', 'Page '.$entity->getName().' was modified');
						return $this->redirect($this->generateUrl('admin_pages'));															
					}
		}

        return array(
            'entity'      => $entity,
			'id'      => $id,
            'edit_form'   => $editForm->createView()
        );
    }		
	
}

