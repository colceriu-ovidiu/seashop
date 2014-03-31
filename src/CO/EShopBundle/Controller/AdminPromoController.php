<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\Promo;
use CO\EShopBundle\Form\PromoType;

/**
 * Category controller.
 *
 * @Route("/admin/promo")
 */
class AdminPromoController extends Controller {
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_promo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('COEShopBundle:Promo')->findAll();
				
				$entity  = new Promo();
				$editForm = $this->createForm(new PromoType(), $entity);

        return array(
            'entities' => $entities,
						'edit_form'   => $editForm->createView()
        );
    }
		
		
		
    /**
     * Add a Promo entity.
     *
     * @Route("/add", name="admin_promo_add")
     * @Method("POST")
     */
    public function addAction(Request $request)
    {
				$entity  = new Promo();
					
        $editForm = $this->createForm(new PromoType(), $entity);
				
				$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
					if ($editForm->isValid()) {
						$em = $this->getDoctrine()->getEntityManager();
        		$em->persist($entity);
        		$em->flush();
        
        		$this->get('session')->setFlash('notice', 'Produsul '.$entity->getProduct()->getName().' a fost adaugat la promo');
						
						return $this->redirect($this->generateUrl('admin_promo'));
					}
				}
    }
		
		
    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="admin_promo_delete")
     */
    public function deleteAction(Request $request, $id)
    {
				$em = $this->getDoctrine()->getManager();
				$entity = $em->getRepository('COEShopBundle:Promo')->find($id);

				if (!$entity) {
						throw $this->createNotFoundException('Unable to find Category entity.');
				}

				$em->remove($entity);
				$em->flush();

        return $this->redirect($this->generateUrl('admin_promo'));
    }
		
}
