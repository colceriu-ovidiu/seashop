<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CO\EShopBundle\Entity\Category
 *
 * @ORM\Table("category")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\CategoryRepository")
 */
class Category
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
		
    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", fetch="LAZY")
     */
    private $childrens;
		
		/**
		 * @ORM\ManyToOne(targetEntity="Category", inversedBy="childrens")
		 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
		 */
		private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */     
     protected $products;
		 
    /**
     * @var SmallInt $type
     *
     * @ORM\Column(name="type", type="smallint", options={"default" = 0})
     */
    private $type;

    /**
     * @var text $slug
     *
     * @ORM\Column(name="slug", type="text")
     */
    protected $slug;

    /**
     * @var text $metadescription
     *
     * @ORM\Column(name="metadescription", type="text")
     */
    private $metadescription;

    /**
     * @var text $metakeywords
     *
     * @ORM\Column(name="metakeywords", type="text")
     */
    private $metakeywords;    

		 
//-----------------------------------------------------------
		 
     public function __construct() {
        $this->products = new ArrayCollection();
				$this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
     }         

		/**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        $this->slug = $this->slugify($this->name);
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set parent
     *
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Category 
     */
    public function getParent()
    {
        return $this->parent;
    }
		

    /**
     * Add children
     *
     * @param CO\EShopBundle\Entity\Category $category
     */
    public function addChildren(\CO\EShopBundle\Entity\Category $category)
    {
        $this->childrens[] = $category;
    }

    /**
     * Get childrens
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

		 /**
     * Add products
     *
     * @param CO\EShopBundle\Entity\Product $products
     */
    public function addProduct(\CO\EShopBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
		

    /**
     * Get type
     *
     * @return smallint 
     */	
		public function getType() {
			return $this->type;
		}

    /**
     * Set type
     *
     * @param smallint $type
     */
		public function setType($type) {
			$this->type = $type;
		}
	
    /**
     * Get slug
     *
     * @return text 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
		
    public function __toString()
    {
       return $this->getName();
    }

    /**
     * Set metadescription
     *
     * @param text $metadescription
     */
    public function setMetadescription($metadescription)
    {
        $this->metadescription = $metadescription;
    }

    /**
     * Get metadescription
     *
     * @return text 
     */
    public function getMetadescription()
    {
        return $this->metadescription;
    }
    
    /**
     * Set metakeywords
     *
     * @param text $metakeywords
     */
    public function setMetakeywords($metakeywords)
    {
        $this->metakeywords = $metakeywords;
    }

    /**
     * Get metakeywords
     *
     * @return text 
     */
    public function getMetakeywords()
    {
        return $this->metakeywords;
    }    


    /**
     * Remove childrens
     *
     * @param CO\EShopBundle\Entity\Category $childrens
     */
    public function removeChildren(\CO\EShopBundle\Entity\Category $childrens)
    {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Remove products
     *
     * @param CO\EShopBundle\Entity\Product $products
     */
    public function removeProduct(\CO\EShopBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

}