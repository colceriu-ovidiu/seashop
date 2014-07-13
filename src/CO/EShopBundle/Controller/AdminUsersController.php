<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\User;
use CO\EShopBundle\Form\UserType;

/**
 * Category controller.
 *
 * @Route("/admin/users")
 */
class AdminUsersController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_users")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('COEShopBundle:User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="admin_users_edit")
     * @Template()
     */
    public function editAction($id)
    {
		if ($id>0) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('COEShopBundle:User')->find($id);
			if (!$entity) {
					throw $this->createNotFoundException('Unable to find User entity.');
			}
		} else {
			$entity  = new User();
		}
					
		$editForm = $this->createForm(new UserType(), $entity);
				
		$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
			if ($editForm->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($entity);
				$em->flush();

				$this->get('session')->setFlash('notice', 'User '.$entity->getName().' was added');

//				$referer_url = $request->headers->get('referer');
//				$response = new RedirectResponse($referer_url);
//				return $response;

				return $this->redirect($this->generateUrl('admin_users'));
			}
		}

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="admin_user_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('COEShopBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_category'));
    }

}
