<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\Banner;
use CO\EShopBundle\Form\BannerType;

/**
 * Category controller.
 *
 * @Route("/admin/banner")
 */
class AdminBannerController extends Controller {
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_banner")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('COEShopBundle:Banner')->findAll();

        return array(
            'entities' => $entities,
        );
    }
		
    /**
     * Displays a form to edit an existing Banner entity.
     *
     * @Route("/{id}/edit", name="admin_banner_edit")
     * @Template()
     */
    public function editAction($id)
    {
				if ($id>0) {
					$em = $this->getDoctrine()->getManager();
					$entity = $em->getRepository('COEShopBundle:Banner')->find($id);
					if (!$entity) {
							throw $this->createNotFoundException('Unable to find Category entity.');
					}
				} else {
					$entity  = new Banner();
				}
					
        $editForm = $this->createForm(new BannerType(), $entity);
				
				$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
					if ($editForm->isValid()) {
						$em = $this->getDoctrine()->getManager();
        		$em->persist($entity);
        		$em->flush();
        
        		$this->get('session')->setFlash('notice', 'Catagory '.$entity->getName().' was added');
						
						return $this->redirect($this->generateUrl('admin_banner'));
					}
				}

        return array(
            'entity'      => $entity,
            'id'				  => $id,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="admin_banner_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('COEShopBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_category'));
    }
		
}
