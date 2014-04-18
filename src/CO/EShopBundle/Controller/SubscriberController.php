<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\Subscriber;
use CO\EShopBundle\Form\SubscriberType;

/**
 * Category controller.
 *
 */
class SubscriberController extends Controller
{

    /**
     * subscriber register action
     *
     * @Route("/register", name="subscribers_register")
		 * @Template
     */
    public function registerAction(Request $request)
    {
        $entity  = new Subscriber();
        $form = $this->createForm(new SubscriberType(), $entity);
				
				if ($request->getMethod() == 'POST') {
					$form->bind($request);

					$urlBack = $request->headers->get("referer");
					
					if ($form->isValid()) {
							$repo = $this->getDoctrine()->getRepository('COEShopBundle:Subscriber');
							$existEnt = $repo->findOneByEmail($entity->getEmail());
							if ($existEnt==null) {
								$em = $this->getDoctrine()->getManager();
								$em->persist($entity);
								$em->flush();
							}

							$this->get('session')->setFlash('notice', 'Adresa '.$entity->getEmail().' s-a abonat la newsletter');
							
							return $this->redirect($urlBack);
					} else {
						  $this->get('session')->setFlash('notice', $form->getErrorsAsString());
							return $this->redirect($urlBack);
					}
				}

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
	
	
    /**
     * Lists all Category entities.
     *
     * @Route("/admin/subscribers/", name="admin_subscribers")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('COEShopBundle:Subscriber')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/admin/subscribers/{id}/delete", name="admin_subscriber_delete")
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
