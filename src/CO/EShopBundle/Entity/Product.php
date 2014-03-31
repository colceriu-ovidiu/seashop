<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

//use CO\EShopBundle\Entity\Discount;


/**
 * CO\EShopBundle\Entity\Product
 *
 * @ORM\Table(name="product") 
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product
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
     * @var float $price
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float $finalprice
     *
     * @ORM\Column(name="finalprice", type="float")
     */
    private $finalprice;

    /**
     * @var text $shortdesc
     *
     * @ORM\Column(name="shortdesc", type="text")
     */
    private $shortdesc;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var text $metadescription
     *
     * @ORM\Column(name="metadescription", type="text", nullable=true)
     */
    private $metadescription;

    /**
     * @var text $metakeywords
     *
     * @ORM\Column(name="metakeywords", type="text", nullable=true)
     */
    private $metakeywords;

    /**
     * @var string $picsrc
     *
     * @ORM\Column(name="picsrc", type="string", length=255, nullable=true)
     */
    private $picsrc;
    
    /**
    * @Assert\File(maxSize="6000000")
    */
    public $pic_file;
			
		/**
     * @ORM\Column(type="datetime")
     */
    protected $updated;	
	
	/**
	* @ORM\OneToOne(targetEntity="Banner")
	*/
    protected $banner;

    /**
     * @var text $slug
     *
     * @ORM\Column(name="slug", type="text")
     */
    protected $slug;

    /**
     * @var string $um
     *
     * @ORM\Column(name="um", type="string", length=100, nullable=true)
     */
    private $um;
	
    /**
     * @var boolean $available
     *
     * @ORM\Column(name="available", type="boolean", nullable=true)
     */
    private $available;

    /**
     * @ORM\ManyToOne(targetEntity="Discount", inversedBy="discount")
     * @ORM\JoinColumn(name="discount_id", referencedColumnName="id", nullable=true)
     */
     protected $discount; 

     

	
// ---------------------- functional -------------------------------------------	
    public function __construct()
    {
        $this->setUpdated(new \DateTime());
    }		
	
    public function getAbsolutePath()
    {
    	return null === $this->picsrc ? null : $this->getUploadRootDir().'/'.$this->picsrc;
    }
    
    public function getWebPath()
    {
    	return null === $this->picsrc ? null : $this->getUploadDir().'/'.$this->picsrc;
    }
    
    protected function getUploadRootDir()
    {
    	// the absolute directory path where uploaded documents should be saved
    	return __DIR__.'/../../../../public_html/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
    	// get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
    	return 'uploads/prodpics';
    }
    
    
    // ---  it generates a unique filename before persisting, moves the file after persisting, and removes the file if the entity is ever deleted. ---

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preSave()
    {
    	if (null !== $this->pic_file) {
				// remove existent
				$this->removeUpload();
				
    		// do whatever you want to generate a unique name
    		//$this->picsrc = uniqid().'.'.$this->pic_file->guessExtension();
            $this->picsrc = $this->slug.'.'.$this->pic_file->guessExtension();
    	}

		$this->calculateFinalPrice();
		
		$this->setUpdated(new \DateTime());	
    }


	public function calculateFinalPrice() {
		$discount = $this->getDiscount();
		if ($discount!=null) {
			if ($discount->getApplytype()==1)
			{
				$this->setFinalPrice( $this->getPrice()*(100-$discount->getPercent())/100 );
			}
			else
			if ($discount->getApplytype()==2)
			{
				$this->setFinalPrice( $this->getPrice()-$discount->getSum() );
			}
		} else {
			$this->setFinalPrice( $this->getPrice() );
		}	
	}

	
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
    	if (null === $this->pic_file) {
    		return;
    	}
			
    	// if there is an error when moving the file, an exception will
    	// be automatically thrown by move(). This will properly prevent
    	// the entity from being persisted to the database on error
    	$this->pic_file->move($this->getUploadRootDir(), $this->picsrc);

    	unset($this->pic_file);
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
    	if ($file = $this->getAbsolutePath()) {
    		unlink($file);
    	}
    }

	
	public function __toString()
    {
       return $this->getName();
    }
//==============================================================================	
	

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
     * Set price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set finalprice
     *
     * @param float $finalprice
     */
    public function setFinalPrice($finalprice)
    {
        $this->finalprice = $finalprice;
    }

    /**
     * Get finalprice
     *
     * @return float 
     */
    public function getFinalPrice()
    {
        return $this->finalprice;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="product")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
     protected $category;              

    /**
     * Set category
     *
     * @param CO\EShopBundle\Entity\Category $category
     */
    public function setCategory(\CO\EShopBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return CO\EShopBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set discount
     *
     * @param CO\EShopBundle\Entity\Discount $discount
     */
    public function setDiscount(\CO\EShopBundle\Entity\Discount $discount = null)
    {
        $this->discount = $discount;
    }

    /**
     * Get discount
     *
     * @return CO\EShopBundle\Entity\Discount 
     */
    public function getDiscount()
    {
        return $this->discount;
    }
    
    /**
    * Set description
    *
    * @param text $picsrc
    */
    public function setPicsrc($picsrc)
    {
    	$this->picsrc = $picsrc;
    }
    
    /**
     * Get description
     *
     * @return text
     */
    public function getPicsrc()
    {
    	return $this->picsrc;
    }


    /**
     * Set shortdesc
     *
     * @param string $shortdesc
     * @return Product
     */
    public function setShortdesc($shortdesc)
    {
        $this->shortdesc = $shortdesc;

        $this->slug = $this->slugify($this->shortdesc);
    
        return $this;
    }

    /**
     * Get shortdesc
     *
     * @return string 
     */
    public function getShortdesc()
    {
        return $this->shortdesc;
    }

    /**
     * Set um
     *
     * @param string $um
     */
    public function setUm($um)
    {
        $this->um = $um;
    }

    /**
     * Get um
     *
     * @return string 
     */
    public function getUm()
    {
        return $this->um;
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return Product
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set banner
     *
     * @param \CO\EShopBundle\Entity\Banner $banner
     * @return Product
     */
    public function setBanner(\CO\EShopBundle\Entity\Banner $banner = null)
    {
        $this->banner = $banner;
    
        return $this;
    }

    /**
     * Get banner
     *
     * @return \CO\EShopBundle\Entity\Banner 
     */
    public function getBanner()
    {
        return $this->banner;
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
		$text = str_replace('\\','-', $text);

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

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Set available
     *
     * @param boolean $available
     * @return Product
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    
        return $this;
    }

    /**
     * Get available
     *
     * @return boolean 
     */
    public function getAvailable()
    {
        return $this->available;
    }
}