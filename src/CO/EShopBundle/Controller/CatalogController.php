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

class CatalogController extends Controller
{

    /**    
     * @Template()              
     */
    public function treeAction($cat_id=0) 
    {
        $repository = $this->getDoctrine()->getRepository('COEShopBundle:Category');
        $categories = $repository->findBy(array(
								'parent' => null
							),
							array(
								'name' => 'ASC'
							)
						);

        if ($cat_id>0) {
          $em = $this->getDoctrine()->getManager();
          $category = $em->getRepository('COEShopBundle:Category')->find($cat_id);
          $parrent_cat_id = $category->getParent()->getId();
        } else {
          $parrent_cat_id = 0;
        }
				
        return array(
        	'items'=>$categories, 
			'current_cat_id'=>$cat_id,
          'parrent_cat_id'=>$parrent_cat_id,
        );  
    }
    
    /**
     * @Route("/catalog/{category_slug}/{pag}", name="_product_list", defaults={"pag" = 1})
     * @Template
     */
    public function productListAction($category_slug, $pag=1) {
        // get category
        $repository = $this->getDoctrine()->getRepository('COEShopBundle:Category');
        $category = $repository->findOneBySlug($category_slug);

        // get products
		$repository = $this->getDoctrine()->getRepository('COEShopBundle:Product');
		
		$items_per_page = $this->container->getParameter('items_per_page');
    	$products = $repository->getByCategory($category->getId(), ($pag-1)*$items_per_page, $items_per_page);
		
		$pag_total = ceil( $repository->getByCategoryCount($category->getId()) / $items_per_page );
		
		$router = $this->get('router');
		$link = $url = $router->generate('_product_list', array('category_slug' => $category->getSlug(), ));
		
		return array(
				'category_name' => $category->getName(), 
				'products'=>$products, 
				'cat_id'=>$category->getId(),

				'pag_nr'=>$pag,
				'pag_total'=>$pag_total,
				'link'=>$link,
        'meta_description'=>$category->getMetadescription(),
        'meta_keywords'=>$category->getMetakeywords(),
		);
    }

    /**
     * @Route("/search", name="_product_search")
     * @Template()
     */
    public function productSearchAction(Request $request) {
			$src = $request->request->get('src');
		if (strlen($src)<3) {
			return array(
					'products'=>array(),
					'cat_id'=>0,
					'error'=>'cuvantul cautat trebuie sa aiba mai mult de 2 caractere'
			);			
		}
			
      $repository = $this->getDoctrine()->getRepository('COEShopBundle:Product');
    	$prodsByName = $repository->findByNameContains($src);
        $prodsByDesc = $repository->findByShortdescContains($src);

        $products = array();
        $products = array_merge($products, $prodsByName);
        $products = array_merge($products, $prodsByDesc);
			
			return array(
					'products'=>$products,
					'cat_id'=>0,
					'error'=> false
			);
    }
		
    /**
    * @Route("/{prod_slug}_{prod_id}", name="_view_product")
    * @Template()
    */
    public function showProductAction($prod_slug, $prod_id)
    {
   		$em = $this->getDoctrine()->getManager();
   		$product = $em->getRepository('COEShopBundle:Product')->find($prod_id);
   		$picsrc = $product->getPicsrc();

   		$request = $this->getRequest();
   		
    	return array(
                	'product'=>$product,
                	'cat_id'=>$product->getCategory()->getId(),
                  'meta_description'=>$product->getMetadescription(),
                  'meta_keywords'=>$product->getMetakeywords(),
    				'url_back'=>$request->headers->get('referer'),
					"show_phone"=>$this->container->getParameter('show_phone')
    	);
    }


    // ------- setup ---------------
    /**
    * @Route("/setup/setslug", name="_set_slug")
    */
    public function setslugAction()
    {
        $em = $this->getDoctrine()->getManager();

		echo "catagories <br />";
        $items = $em->getRepository('COEShopBundle:Category')->findAll();
        foreach ($items as $item) {
			echo $item->getId()." - ".$item->slugify($item->getName())."*<br />";
            $item->setSlug( $item->slugify($item->getName()) );
            $em->persist($item);
        }
 
		echo "products <br />";
        $items = $em->getRepository('COEShopBundle:Product')->findAll();
        foreach ($items as $item) {
			echo $item->getId()." - ".$item->slugify($item->getShortDesc())."*<br />";
            $item->setSlug( $item->slugify($item->getShortDesc()) );
            $em->persist($item);
        }
 
        $em->flush();
        
		echo "...DONE";

        return array();
    }


    
    
}
