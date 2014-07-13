<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\Category;
use CO\EShopBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/admin/category")
 */
class AdminCategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_category")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('COEShopBundle:Category');
				
		// get normal categories
        $categories = $repository->findBy(array('type' => 0,	'parent' => null),
							array('name' => 'ASC')
						);
				
		// get accesories
		$categories_acc = $repository->findBy(array('type' => 1,'parent' => null),
					array('name' => 'ASC')
				);
				
		// get genti
		$categories_genti = $repository->findBy(array('type' => 2,'parent' => null),
					array('name' => 'ASC')
				);
				
				
        return array(
        	'categories'=>$categories, 
        	'categories_acc'=>$categories_acc, 
        	'categories_genti'=>$categories_genti, 
        );  
				
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="admin_category_edit")
     * @Template()
     */
    public function editAction($id)
    {
				if ($id>0) {
					$em = $this->getDoctrine()->getManager();
					$entity = $em->getRepository('COEShopBundle:Category')->find($id);
					if (!$entity) {
							throw $this->createNotFoundException('Unable to find Category entity.');
					}
				} else {
					$entity  = new Category();
				}
					
        $editForm = $this->createForm(new CategoryType(), $entity);
				
				$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
					if ($editForm->isValid()) {
						$em = $this->getDoctrine()->getManager();
        		$em->persist($entity);
        		$em->flush();
        
        		$this->get('session')->setFlash('notice', 'Catagory '.$entity->getName().' was added');
						
//						$referer_url = $request->headers->get('referer');
//        		$response = new RedirectResponse($referer_url);
//        		return $response;
						
						return $this->redirect($this->generateUrl('admin_category'));
					}
				}

        return array(
            'entity'      => $entity,
						'id'      => $id,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="admin_category_delete")
     */
    public function deleteAction($id)
    {
        if ($id>0) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('COEShopBundle:Category')->find($id);

            if (!$entity) {
							  $this->get('session')->setFlash('error', 'Unable to find Category entity.');
                //throw $this->createNotFoundException('Unable to find Category entity.');
            } else if($entity->getProducts()->count()>0) {
							  $this->get('session')->setFlash('error', 'Category '.$entity->getName().' has products');
						}
						else 
						{
							$em->remove($entity);
							$em->flush();

							$this->get('session')->setFlash('notice', 'Category '.$entity->getName().' was deleted');
						}
        }

        return $this->redirect($this->generateUrl('admin_category'));
    }

}
