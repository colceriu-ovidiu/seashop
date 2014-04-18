<?php

namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Form\MailTemplateType;
use CO\EShopBundle\Entity\MailTemplate;
use Symfony\Component\Finder\Finder;

/**
 * SiteVars controller.
 *
 * @Route("/admin/mailtemplates")
 */
class AdminMailTemplatesController extends Controller
{
	
	const DIR_EMAIL_TEMPLATES = "/../Resources/views/Email";
	
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_mailtemplates")
     * @Template()
     */
    public function indexAction()
    {
		$finder = new Finder();
		$finder->files()->in(__DIR__.self::DIR_EMAIL_TEMPLATES);
		
		$entities = array();
		foreach ($finder as $file) {
			// Print the absolute path
			$entities[] = $file->getFilename();
		}
		
        return array(
            'entities' => $entities,
        );
    }
		
    /**
     * Displays a form to edit an existing SiteVars entity.     
	*     
	* @Route("/{fname}/edit", name="admin_mailtemplates_edit")     
	* @Template()    
	*/    
   public function editAction($fname)  {	
	   $file_path = __DIR__.self::DIR_EMAIL_TEMPLATES . '/'. $fname;

	   if (!file_exists($file_path)) {
		   throw $this->createNotFoundException($file_path . ' was not found!');
	   }

	   $content = file_get_contents($file_path);

	   $entity = new MailTemplate();
	   $entity->setContent($content);
	   $editForm = $this->createForm(new MailTemplateType(), $entity);		

	   $request = $this->getRequest();        
	   if ($request->getMethod() == 'POST') {
		   $editForm->bindRequest($request);					
		   if ($editForm->isValid()) {
			   file_put_contents($file_path, stripslashes($entity->getContent()) );
			   
			   $this->get('session')->setFlash('notice', 'Template '.$fname.' was changed');												
			   return $this->redirect($this->generateUrl('admin_mailtemplates'));															
		   }
	   }

	   return array(
		   /*'entity'      => $entity,*/
		   'fname'      => $fname,
		   'edit_form'   => $editForm->createView()
	   );
    }		
	
}

