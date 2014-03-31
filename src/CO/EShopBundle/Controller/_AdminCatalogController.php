<?php

namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use CO\EShopBundle\Entity\Category;
use CO\EShopBundle\Entity\Product;

use CO\EShopBundle\Form\Type\ProductType;

class AdminCatalogController extends Controller
{

    /**
    * @Route("/secured/catalog/tree/edit/{cat_id}", name="_edit_category", defaults={"cat_id" = 0})
    * @Template()
    */
    public function editCategoryAction($cat_id)
    {
    	if ($cat_id>0) {
        	$em = $this->getDoctrine()->getEntityManager();
        	$category = $em->getRepository('COEShopBundle:Category')->find($cat_id);
        } else {
        	$category = new Category();
        }
    
        $form = $this->createFormBuilder($category)
          ->add('name', 'text')
          ->getForm();
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$form->bindRequest($request);
        
        	if ($form->isValid()) {
        		$em = $this->getDoctrine()->getEntityManager();
        		$em->persist($category);
        		$em->flush();
        
        		$this->get('session')->setFlash('notice', 'Catagory '.$category->getName().' was added');
        		
        		$referer_url = $request->headers->get('referer');
        		$response = new RedirectResponse($referer_url);
        		return $response;
        	}
        } 
                
        return array(
        	'form'=>$form->createView()
        );  
    }
        
    /**
    * @Route("/secured/catalog/tree/delete/{cat_id}", name="_delete_category", defaults={"cat_id" = 0})
    */
    public function deleteCategoryAction($cat_id)
    {
    	if ($cat_id>0) {
        	$em = $this->getDoctrine()->getEntityManager();
        	$category = $em->getRepository('COEShopBundle:Category')->find($cat_id);
        	$em->remove($category);
        	$em->flush();
        	
        	$this->get('session')->setFlash('notice', 'Catagory '.$category->getName().' was deleted');
        	
        	$request = $this->getRequest();
        	$referer_url = $request->headers->get('referer');
        	$response = new RedirectResponse($referer_url);
        	return $response;
        	 
        } else {
        	// throw exception
        }
    }

    /**
    * @Route("/secured/catalog/products_edit/{prod_id}/{cat_id}", name="_edit_product", defaults={"prod_id"=0, "cat_id"=0})
    * @Template()
    */
    public function editProductAction($prod_id, $cat_id)
    {
    	if ($prod_id>0) {
    		$em = $this->getDoctrine()->getEntityManager();
    		$product = $em->getRepository('COEShopBundle:Product')->find($prod_id);
    		$picsrc = $product->getPicsrc();
    		$edit = true;    		
    	} else {
    		$product = new Product();
    		$picsrc = '';
    		$edit = false;
    	}
    
    	$form = $this->createForm(new ProductType(), $product);
    
    	$request = $this->getRequest();
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    
    		if ($form->isValid()) {
    			$em = $this->getDoctrine()->getEntityManager();
    			
    			// set category
    			$category = $em->getRepository('COEShopBundle:Category')->find($cat_id);
    			$product->setCategory($category);
    			
    			// save
    			$em->persist($product);
    			$em->flush();
    
    			// set flash message
    			$this->get('session')->setFlash('notice', 'Product '.$product->getName().' was added');
    
    			// redirect
//     			$referer_url = $request->headers->get('referer');
//     			$response = new RedirectResponse($referer_url);
//     			return $response;

    			return $this->redirect( $this->generateUrl('_product_list', array('category_name'=>$category->getName())) );
				
    		} else {
    			// form is not valid
    			echo "FORM is NOT VALIED";
    		}
    	}
    
    	return array(
            	'form'=>$form->createView(),
            	'cat_id'=>$cat_id,
            	'edit'=>$edit,
            	'picsrc'=>$picsrc,
    			'url_back'=>$request->headers->get('referer')
    	);
    }
    
    /**
    * @Route("/secured/catalog/catalog/delete/{product_id}", name="_delete_product" )
    */
    public function deleteProductAction($product_id)
    {
    	if ($product_id>0) {
    		$em = $this->getDoctrine()->getEntityManager();
    		$product = $em->getRepository('COEShopBundle:Product')->find($product_id);
    		$em->remove($product);
    		$em->flush();
    		 
    		$this->get('session')->setFlash('notice', 'Product '.$product->getName().' was deleted');
    		 
    		$request = $this->getRequest();
    		$referer_url = $request->headers->get('referer');
    		$response = new RedirectResponse($referer_url);
    		return $response;
    
    	} else {
    		// throw exception
    	}
    }
    
    /**
     * @Route("/secured/catalog/new_product", name="_new_product")
     * @Template
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);
    
        // ...
        if ($request->getMethod()=='POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($product);
                $em->flush();
            
                //return $this->redirect($this->generateUrl('task_success'));
            }
        }
        
        return array('form'=>$form->createView());
    }
    
}
