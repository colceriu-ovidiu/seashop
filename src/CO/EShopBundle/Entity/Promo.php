<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * CO\EShopBundle\Entity\Banner
 *
 * @ORM\Table("promo")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\PromoRepository")
 */
class Promo {
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	 
		/**
		 * @ORM\OneToOne(targetEntity="Product", mappedBy="Promo")
		 * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
		 */
		private $product;	 
		
		/**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

		
    public function __construct()
    {
        $this->setUpdated(new \DateTime());
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