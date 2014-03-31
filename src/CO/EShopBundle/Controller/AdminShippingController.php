<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\ShippingMethod;
use CO\EShopBundle\Form\ShippingMethodType;

/**
 * Category controller.
 *
 * @Route("/admin/shipping")
 */class AdminShippingController extends Controller
{
    /**
     * Lists all Shipping entities.
     *
     * @Route("/", name="admin_shipping")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('COEShopBundle:ShippingMethod');
				
	// get normal categories
        $items = $repository->findAll();				
				
        return array(
	    'items'=>$items, 
        );  
				
    }
    

    /**
     * Displays a form to edit an existing Shipping-Method entity.
     *
     * @Route("/{id}/edit", name="admin_shipping_edit")
     * @Template()
     */
    public function editAction($id)
    {
	$em = $this->getDoctrine()->getManager();

	if ($id>0) {
		$entity = $em->getRepository('COEShopBundle:ShippingMethod')->find($id);
		if (!$entity) {
				throw $this->createNotFoundException('Unable to find ShippingMethod entity.');
		}
	} else {
		$entity  = new ShippingMethod();
	}
			
        $editForm = $this->createForm(new ShippingMethodType(), $entity);

	$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
		if ($editForm->isValid()) {
        		$em->persist($entity);
        		$em->flush();
        
        		$this->get('session')->setFlash('notice', 'Shipping-Method '.$entity->getName().' was saved');
						
			return $this->redirect($this->generateUrl('admin_shipping'));
		}
	}
				
        return array(
	    'curr_menu'=> 'catalog',
            'entity'      => $entity,
            'id'      => $id,
            'edit_form'   => $editForm->createView()
        );
    }
    

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}/delete", name="admin_shipping_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        if ($id>0) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('COEShopBundle:ShippingMethod')->find($id);

            if (!$entity) {
				$this->get('session')->setFlash('error', 'Unable to find Shipping-Method entity.');
                //throw $this->createNotFoundException('Unable to find Category entity.');
            } 
			// serch for orders
			else 
			{
				$em->remove($entity);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Shipping-Method '.$entity->getName().' was deleted');
			}
        }

        return $this->redirect($this->generateUrl('admin_product'));
    }


}

?>
