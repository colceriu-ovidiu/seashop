<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\Product;
use CO\EShopBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/admin/product")
 */
class AdminProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/list/{pag}", name="admin_product", defaults={"pag" = 1})
     * @Template()
     */
    public function indexAction($pag=1)
    {
        $em = $this->getDoctrine()->getManager();

        $items_per_page = $this->container->getParameter('admin_items_per_page');

        $repository = $em->getRepository('COEShopBundle:Product');

        $entities = $repository->findAllAsArr(($pag-1)*$items_per_page, $items_per_page);

        $pag_total = ceil( $repository->findAllCount() / $items_per_page );

        return array(
            'entities' => $entities,
            'pag_curr' => $pag,
            'pag_nr'=>$pag,
            'pag_total'=>$pag_total,
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="admin_product_edit")
     * @Template()
     */
    public function editAction($id)
    {
				if ($id>0) {
					$em = $this->getDoctrine()->getManager();
					$entity = $em->getRepository('COEShopBundle:Product')->find($id);
					if (!$entity) {
							throw $this->createNotFoundException('Unable to find Product entity.');
					}
				} else {
					$entity  = new Product();
				}
			
        $editForm = $this->createForm(new ProductType(), $entity);

		$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
					if ($editForm->isValid()) {						
						$em = $this->getDoctrine()->getManager();
        				$em->persist($entity);
        				$em->flush();
        
        				$this->get('session')->setFlash('notice', 'Product '.$entity->getName().' was added');
						
						return $this->redirect($this->generateUrl('admin_product'));
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
     * when login changes all products should be saved
     *
     * @Route("/saveall", name="admin_product_save_all")
     * @Method("GET")
     */
    public function saveallAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('COEShopBundle:Product');
        $entities = $repository->findAll();

		foreach ($entities as $entity) {
			$entity->calculateFinalPrice();
			$em->persist($entity);
			$em->flush();
		}

        return array();		
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
            $entity = $em->getRepository('COEShopBundle:Product')->find($id);

            if (!$entity) {
				$this->get('session')->setFlash('error', 'Unable to find Product entity.');
                //throw $this->createNotFoundException('Unable to find Category entity.');
            } 
			// serch for orders
			else 
			{
				$em->remove($entity);
				$em->flush();

				$this->get('session')->setFlash('notice', 'Product '.$entity->getName().' was deleted');
			}
        }

        return $this->redirect($this->generateUrl('admin_product'));
    }

}
