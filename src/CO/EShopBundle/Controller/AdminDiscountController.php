<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\Discount;
use CO\EShopBundle\Form\DiscountType;

/**
 * Product controller.
 *
 * @Route("/admin/discount")
 */
class AdminDiscountController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="admin_discount")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('COEShopBundle:Discount');

        $entities = $repository->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="admin_discount_edit")
     * @Template()
     */
    public function editAction($id)
    {
	$em = $this->getDoctrine()->getManager();
				if ($id>0) {
					$entity = $em->getRepository('COEShopBundle:Discount')->find($id);
					if (!$entity) {
							throw $this->createNotFoundException('Unable to find Descount entity.');
					}
				} else {
					$entity  = new Discount();
				}
			
        $editForm = $this->createForm(new DiscountType(), $entity);

				$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
					if ($editForm->isValid()) {
        		$em->persist($entity);
        		$em->flush();
        
        		$this->get('session')->setFlash('notice', 'Discount '.$entity->getName().' was added');
						
						return $this->redirect($this->generateUrl('admin_discount'));
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
     * @Route("/{id}/delete", name="admin_product_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        if ($id>0) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('COEShopBundle:Discount')->find($id);

            if (!$entity) {
				$this->get('session')->setFlash('error', 'Unable to find Product entity.');
                //throw $this->createNotFoundException('Unable to find Category entity.');
            } 
			// serch for orders
			else 
			{
				$em->remove($entity);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Discount '.$entity->getName().' was deleted');
			}
        }

        return $this->redirect($this->generateUrl('admin_product'));
    }

}
