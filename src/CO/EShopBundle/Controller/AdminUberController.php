<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Form\DiscountType;

/**
 * Product controller.
 *
 */
class AdminUberController extends Controller
{
	var $entityName;
	var $itemName;
	var $entityFresh;
	var $formType;
	var $routeListing;
	var $curr_menu;
	
	
	public function __construct()
	{
		/*
		$this->entityName = 'Bundle:Entity';
		$this->itemName = 'Entity';
		$this->entityFresh = new Entity();
		$this->formType = new EntityType();
		$this->routeListing = 'admin_items';
		$this->curr_menu = 'catalog';
 		*/
	}
	
    /**
     * Lists all Product entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository($this->entityName);

        $entities = $repository->findAll();

		return $this->render(
            'COEShopBundle:AdminUber:index.html.twig',
            array(
				'entities' => $entities,
				'itemName' => $this->itemName,
			)
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="admin_cattype_edit")
     * @Template()
     */
    public function editAction($id)
    {
		$em = $this->getDoctrine()->getManager();
		
		if ($id>0) {
			$entity = $em->getRepository($this->entityName)->find($id);
			if (!$entity) {
				throw $this->createNotFoundException('Unable to find '.$this->entityName.' entity.');
			}
		} else {
			$entity  = $this->entityFresh;
		}
			
        $editForm = $this->createForm($this->formType, $entity);

		$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
			if ($editForm->isValid()) {
				$em->persist($entity);
				$em->flush();

				$this->get('session')->setFlash('notice', $this->itemName.' '.$entity->getName().' was added');

				return $this->redirect($this->generateUrl($this->routeListing));
			}
		}
				
        return $this->render(
            'COEShopBundle:AdminUber:edit.html.twig',
			array(
			  'itemName' => $this->itemName,
			  'curr_menu'=> 'catalog',
			  'entity'=> $entity,
			  'id'=> $id,
			  'edit_form' => $editForm->createView()
			)
		);
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}/delete", name="admin_product_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        if ($id>0) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('COEShopBundle:Discount')->find($id);

            if (!$entity) {
				$this->get('session')->setFlash('error', 'Unable to find '.$this->entityName.' entity.');
                //throw $this->createNotFoundException('Unable to find Category entity.');
            } 
			// serch for orders
			else 
			{
				$em->remove($entity);
				$em->flush();

				$this->get('session')->setFlash('notice', $this->itemName.' '.$entity->getName().' was deleted');
			}
        }

        return $this->redirect($this->generateUrl($this->routeListing));
    }

}
