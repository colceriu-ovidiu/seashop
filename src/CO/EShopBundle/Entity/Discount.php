<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * CO\EShopBundle\Entity\Discount
 *
 * @ORM\Table("discounts")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\DiscountRepository")
 */
class Discount {
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
	* @var smallint $applyType
	*
	* @ORM\Column(name="apply_type", type="smallint")
	*/
	private $applyType;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="product")
     */     
     protected $products;

	/**
    * @ORM\Column(name="percent", type="integer")
	*/
	private $percent;
	
	/**
    * @ORM\Column(name="sum", type="decimal", precision=2, scale=1)
	*/
	private $sum;
		
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
     * Set name
     *
     * @param string $name
     * @return Discount
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
     * Set applyType
     *
     * @param SmallInt $applyType
     * @return Discount
     */
    public function setApplyType($applyType)
    {
        $this->applyType = $applyType;
    
        return $this;
    }

    /**
     * Get applyType
     *
     * @return SmallInt
     */
    public function getApplyType()
    {
        return $this->applyType;
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
     * Get products
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set percent
     *
     * @param \Integer $percent
     * @return Discount
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;
    
        return $this;
    }

    /**
     * Get percent
     *
     * @return \Integer 
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set sum
     *
     * @param \Decimal $sum
     * @return Discount
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    
        return $this;
    }

    /**
     * Get sum
     *
     * @return \Decimal 
     */
    public function getSum()
    {
        return $this->sum;
    }


    public function __toString()
    {
       return $this->getName();
    }

}