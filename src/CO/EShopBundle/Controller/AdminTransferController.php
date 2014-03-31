<?php

namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/*use CO\EShopBundle\Entity\Newsletter;
use CO\EShopBundle\Form\NewsletterType;
use CO\EShopBundle\Entity\NewsletterSession;*/
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Newsletters controller.
 *
 * @Route("/admin/transfer")
 */
class AdminTransferController extends Controller
{
	
	const EXPORT_FILE = 'export_';
	
    /**
     * 
     *
     * @Route("/export-config", name="admin_transfer_export_config")
     * @Template()
     */
    public function exportConfigAction()
    {
        return array(
        );
    }
		
    /**
     * 
     *
     * @Route("/export", name="admin_transfer_export")
     */
    public function exportAction()
    {
		
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('COEShopBundle:Product');
		
		$entities = $repository->findAllAsArr();
		
		$filename = self::EXPORT_FILE.date("Y_m_d_His").".csv";
		
		$response = new Response( $this->renderView('COEShopBundle:Admin:exportfile.csv.twig', array('entities' => $entities)) );

		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Description', 'Submissions Export');
		$response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
		$response->headers->set('Content-Transfer-Encoding', 'binary');
		$response->headers->set('Pragma', 'no-cache');
		$response->headers->set('Expires', '0');

		$request = Request::createFromGlobals();
		$response->prepare($request);
		$response->sendHeaders();
		$response->sendContent();		
		
        return $response;
    }
		
    /**
     * 
     *
     * @Route("/import-config", name="admin_transfer_import_config")
     * @Template()
     */
    public function importConfigAction()
    {
        return array(
        );
    }
		
    /**
     * Displays a form to edit an existing Category entity.     
	 *     
	 * @Route("/{id}/edit", name="admin_newsletters_edit")     
	 * @Template()    
	 */    
	public function editAction($id)    {
		if ($id>0) {			
			$em = $this->getDoctrine()->getManager();			
			$entity = $em->getRepository('COEShopBundle:Newsletter')->find($id);			
			if (!$entity) {					
				throw $this->createNotFoundException('Unable to find Newsletter entity.');			
			}		
		} else {			
			$entity  = new Newsletter();		
		}			
		$editForm = $this->createForm(new NewsletterType(), $entity);		
		$request = $this->getRequest();        
		if ($request->getMethod() == 'POST') {        	
			$editForm->bindRequest($request);					
			if ($editForm->isValid()) {						
				$em = $this->getDoctrine()->getEntityManager();						
				$em->persist($entity);						
				$em->flush();
				
				$this->get('session')->setFlash('notice', 'Newsletter '.$entity->getName().' was modified');
				return $this->redirect($this->generateUrl('admin_newsletters'));															
			}
		}

		$sessions = $em->getRepository('COEShopBundle:NewsletterSession')->findByNewsletter($entity);

        return array(
            'entity'      => $entity,
			'id'      => $id,
            'edit_form'   => $editForm->createView(),
            'sessions' => $sessions
        );
    }		
	
    /**
     * send a specific newssletter to all subscribers
	 *     
	 * @Route("/{id}/send", name="admin_newsletters_send")     
	 * @Template()    
	 */    
	public function sendAction($id) {
		// get newsletter
		if (!$id>0) {
			throw $this->createNotFoundException('invalid ID');		
		}			
		$em = $this->getDoctrine()->getManager();
		$letter = $em->getRepository('COEShopBundle:Newsletter')->find($id);
		if (!$letter) {
			throw $this->createNotFoundException('Unable to find Newsletter entity.');
		}
		
		// cred record history
		$entityH  = new NewsletterSession();
		$entityH->setNewsletter($letter);
		$em->persist($entityH);
		$em->flush();

		// send mails
		$subscribers = $em->getRepository('COEShopBundle:Subscriber')->findAll();
		foreach ($subscribers as $subscriber) {
            $message = \Swift_Message::newInstance()
				->setSubject( $letter->getName() )
				->setFrom( $this->container->getParameter('email_from') )
				->setTo( $subscriber->getEmail() )
				->setBody($this->renderView('COEShopBundle:Email:newsletter.html.twig', array('content' => $letter->getContent())))
				->setContentType("text/html");
			$this->get('mailer')->send($message);
		}

		// set status to finish
		/*$entityH->set
		$em->persist($entityH);
		$em->flush();*/

		// set session
		$this->get('session')->setFlash('notice', 'Newsletter '.$letter->getName().' was sent');
		return $this->redirect($this->generateUrl('admin_newsletters_edit', array("id"=>$id)));
    }		

}

