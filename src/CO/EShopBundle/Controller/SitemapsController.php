<?php
// src/Acme/Sample/StoreBundle/Controller/SitemapsController.php
namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CO\EShopBundle\Entity\Category;
use CO\EShopBundle\Entity\Product;


class SitemapsController extends Controller
{

    /**
     * @Route("/sitemap.{_format}", name="sample_sitemaps_sitemap", Requirements={"_format" = "xml"})
     * @Template()
     */
    public function sitemapAction() 
    {
        
        $urls = array();
        $hostname = $this->getRequest()->getHost();

        // add some urls homepage
        $urls[] = array('loc' => $this->get('router')->generate('_welcome'), 'changefreq' => 'weekly', 'priority' => '1.0');

        // multi-lang pages
        /*foreach($languages as $lang) {
            $urls[] = array('loc' => $this->get('router')->generate('home_contact', array('_locale' => $lang)), 'changefreq' => 'monthly', 'priority' => '0.3');
        }*/

        // contact
        $urls[] = array('loc' => $this->get('router')->generate('_contact'), 'changefreq' => 'weekly', 'priority' => '1.0');
        
        // urls from database
        //$urls[] = array('loc' => $this->get('router')->generate('home_product_overview', array('_locale' => 'en')), 'changefreq' => 'weekly', 'priority' => '0.7');
        
		// product listing for categories
		$repositoryCat = $this->getDoctrine()->getRepository('COEShopBundle:Category');
		$repositoryProd = $this->getDoctrine()->getRepository('COEShopBundle:Product');
		
        $categories = $repositoryCat->findAll();
		$items_per_page = $this->container->getParameter('items_per_page');
		foreach ($categories as $category) {
			if ($category->getParent()!=null) {
				$pag_total = ceil( $repositoryProd->getByCategoryCount($category->getId()) / $items_per_page );
				for ($i=1; $i<=$pag_total; $i++) {
		            $urls[] = array('loc' => $this->get('router')->generate('_product_list', 
		                    array('category_slug' => $category->getSlug(), 'pag'=>$i)), 'priority' => '0.7');					
				}
			}
		}

		// product details
        foreach ($repositoryProd->findAll() as $product) {
            $urls[] = array('loc' => $this->get('router')->generate('_view_product', 
                    array('prod_slug' => $product->getSlug(), 'prod_id'=>$product->getId())), 'priority' => '0.5');
        }

        return array('urls' => $urls, 'hostname' => $hostname);
    }
}