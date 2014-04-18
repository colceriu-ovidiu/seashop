<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * CO\EShopBundle\Entity\Banner
 *
 * @ORM\Table("banners")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\BannerRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Banner {
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
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

	 
	/**
	 * @ORM\OneToOne(targetEntity="Product", mappedBy="Banner")
	 * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
	 */
	private $product;	 
	

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
    	return 'uploads/banners';
    }
		
    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload()
    {
    	if (null !== $this->pic_file) {
				// remove existent
				$this->removeUpload();
				
    		// do whatever you want to generate a unique name
    		$this->picsrc = uniqid().'.'.$this->pic_file->guessExtension();
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

		/*------------------------- getter setter --------------------------*/
		
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
     * @return Banner
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
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
     * Set description
     *
     * @param string $description
     * @return Banner
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set picsrc
     *
     * @param string $picsrc
     * @return Banner
     */
    public function setPicsrc($picsrc)
    {
        $this->picsrc = $picsrc;
    
        return $this;
    }

    /**
     * Get picsrc
     *
     * @return string 
     */
    public function getPicsrc()
    {
        return $this->picsrc;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Banner
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
     * Set product
     *
     * @param \CO\EShopBundle\Entity\Product $product
     * @return Banner
     */
    public function setProduct(\CO\EShopBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \CO\EShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}