<?php

namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CO\EShopBundle\Form\Type\PageType;
use CO\EShopBundle\Entity\Enquiry;
use CO\EShopBundle\Form\ContactType;

use CO\ArticlesBundle\Entity\Article;
use CO\ArticlesBundle\Repository\ArticleRepository;


class PageController extends UberController
{
    
    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function homeAction()
    {
		$em = $this->getDoctrine()->getEntityManager();

		$article = $em->getRepository('COArticlesBundle:Article')->getLatestBlog();			
    	$promos = $em->getRepository('COEShopBundle:Promo')->findAll();
    	
		return array(
			"article" => $article,
			"promos" => $promos,
			"cat_id" => 0,
		);
    }
   
    /**
     * @Route("/contact", name="_contact")
     * @Template()
     */
    public function contactAction()
    {
		//$enquiry = new Enquiry();
		$form = $this->createForm(new ContactType());
        /*$form = $this->get('form.factory')->create(new ContactType());*/

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $params = array('name'=>$request->get('name'), 'email'=>$request->get('email'), 'body'=>$request->get('body'));
				$this->sendMail(UberController::MAIL_TYPE_CONTACT, $form->getData() );
                $this->get('session')->setFlash('notice', 'Message sent!');
                return new RedirectResponse($this->generateUrl('_contact'));
            }
        }

        return array('form' => $form->createView());        
    }

    /**
     * @Route("/terms", name="_terms")
     * @Template()
     */
    public function termsAction()
    {
        return array();
    }


    /**
     * @Route("/customer-protection", name="_protect")
     * @Template()
     */
    public function protectAction()
    {
        return array();
    }
    
    /**
     * @Route("/links", name="_links")
     * @Template()
     */
    public function linksAction()
    {
        return array();
    }
    
    /**
     * @Route("/page/show/{name}", name="_page_show")
     * @Template()
     */
    public function showAction($name)
    {
    	$repository = $this->getDoctrine()->getRepository('COEShopBundle:Page');
    	$page = $repository->findOneByName($name);
   	
       return array(
       	'id' => $page->getId(), 
       	'name' => $page->getName(), 
       	'content'=>$page->getContent(),
        'meta_description'=>$page->getMetadescription(),
        'meta_keywords'=>$page->getMetakeywords(), 
       );
    }
    
    
    /**
     * @Template
     */         
    public function languageBarAction() {
      $languages = array(
        'ro'=>'Romana',
        'hu'=>'Magyar',
        'en'=>'English',
        'de'=>'Deutsch',
        'fr'=>'Francais'
      );
      $selected = 'en';
      
      return array(
        'languages'=>$languages,
        'selected'=>$selected
      );
    }

		
    /**
     * @Route("/page/banners/", name="_page_banners")
     * @Template()
     */
    public function bannersAction()
    {		
    	$repository = $this->getDoctrine()->getRepository('COEShopBundle:Banner');
    	$banners = $repository->findAll();
    	
        return array(
        	'banners' => $banners
        );
    }		
}

