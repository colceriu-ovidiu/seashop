<?php

namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\ArticlesBundle\Entity\Article;
use CO\ArticlesBundle\Form\ArticleType;

/**
 * Category controller.
 *
 * @Route("/admin/articles")
 */
class AdminArticleController extends Controller
{
	
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_articles")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('COArticlesBundle:Article')->findAll();

        return array(
            'entities' => $entities,
        );
    }
		
    /**
     * Displays a form to edit an existing Category entity.     
		 *     
		 * @Route("/{id}/edit", name="admin_article_edit")     
		 * @Template()    
		 */    
		public function editAction($id)    {		
				if ($id>0) {			
					$em = $this->getDoctrine()->getManager();			
					$entity = $em->getRepository('COArticlesBundle:Article')->find($id);			
					if (!$entity) {					
						throw $this->createNotFoundException('Unable to find Category entity.');			
					}		
				} else {			
					$entity  = new Article();		
				}			
        $editForm = $this->createForm(new ArticleType(), $entity);		
				$request = $this->getRequest();        
				if ($request->getMethod() == 'POST') {        	
					$editForm->bindRequest($request);					
					if ($editForm->isValid()) {						
						$em = $this->getDoctrine()->getManager();
						
						$entity->setAuthor("admin");
						
						$em->persist($entity);						
						$em->flush();
						
						$this->get('session')->setFlash('notice', 'Article '.$entity->getTitle().' was added');												
						return $this->redirect($this->generateUrl('admin_articles'));															
					}
		}

        return array(
            'entity'      => $entity,
						'id'      => $id,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
     * Deletes an article entity.
     *
     * @Route("/{id}/delete", name="admin_article_delete")
     */
    public function deleteAction($id)
    {
        if ($id>0) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('COArticlesBundle:Article')->find($id);

            if (!$entity) {
				$this->get('session')->setFlash('error', 'Unable to find Article entity.');
                //throw $this->createNotFoundException('Unable to find Category entity.');
            } 
			// serch for orders
			else 
			{
				$em->remove($entity);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Article '.$entity->getTitle().' was deleted');
			}
        }

        return $this->redirect($this->generateUrl('admin_articles'));
    }

	
}

