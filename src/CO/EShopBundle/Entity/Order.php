<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CO\EShopBundle\Entity\Order
 *
 * @ORM\Table("orders")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\OrderRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Order 
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="order")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
     protected $user;              

    /**
     * @ORM\ManyToOne(targetEntity="OrderUserData", inversedBy="order")
     * @ORM\JoinColumn(name="order_user_data_id", referencedColumnName="id", nullable=false)
     */
     protected $orderUserData;
	 
    /**
     * @var float $total
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;
		
    /**
     * @var datetime $createTimestamp
     *
     * @ORM\Column(name="create_timestamp", type="datetime", nullable=false)
     */
    private $createTimestamp;
		
	/**
	* @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"persist"})
	*/     
	private $items;
		
	/**
     * @ORM\Column(type="text", nullable=true)
     */
	private $obs;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;
	
    /**
     * @var string $awb
     *
     * @ORM\Column(name="awb", type="string", length=100, nullable=true)
     */
    private $awb;
	
    /**
     * @var integer $shippingcomp
     *
     * @ORM\Column(name="shippingcomp", type="integer")
     */
    private $shippingcomp;

    /**
     * @var string $cancelObs
     *
     * @ORM\Column(name="cancel_obs", type="string", length=300, nullable=true)
     */
    private $cancelObs;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shippingcomp = 0;
    }
		
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreateTimestamp(new \DateTime());
    }
		
		//--------------------------------------------------------------------------
    
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
     * Set total
     *
     * @param float $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set createTimestamp
     *
     * @param \DateTime $createTimestamp
     * @return Order
     */
    public function setCreateTimestamp($createTimestamp)
    {
        $this->createTimestamp = $createTimestamp;
    
        return $this;
    }

    /**
     * Get createTimestamp
     *
     * @return \DateTime 
     */
    public function getCreateTimestamp()
    {
        return $this->createTimestamp;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
	
    /**
     * Get awb
     *
     * @return string 
     */
    public function getAwb()
    {
        return $this->awb;
    }

    /**
     * Set awb
     *
     * @param string $awb
     * @return Order
     */
    public function setAwb($awb)
    {
        $this->awb = $awb;
    
        return $this;
    }
	
    /**
     * Set shippingcomp
     *
     * @param integer $shippingcomp
     * @return Order
     */
    public function setShippingcomp($shippingcomp)
    {
        $this->shippingcomp = $shippingcomp;
    
        return $this;
    }

    /**
     * Get shippingcomp
     *
     * @return integer 
     */
    public function getShippingcomp()
    {
        return $this->shippingcomp;
    }
	
    /**
     * Set user
     *
     * @param CO\EShopBundle\Entity\User $user
     * @return Order
     */
    public function setUser(\CO\EShopBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return CO\EShopBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set orderUserData
     *
     * @param CO\EShopBundle\Entity\OrderUserData $orderUserData
     * @return Order
     */
    public function setOrderUserData(\CO\EShopBundle\Entity\OrderUserData $orderUserData)
    {
        $this->orderUserData = $orderUserData;
    
        return $this;
    }

    /**
     * Get orderUserData
     *
     * @return CO\EShopBundle\Entity\OrderUserData 
     */
    public function getOrderUserData()
    {
        return $this->orderUserData;
    }

    /**
     * Add items
     *
     * @param CO\EShopBundle\Entity\OrderItem $items
     * @return Order
     */
    public function addItem(\CO\EShopBundle\Entity\OrderItem $items)
    {
        $this->items[] = $items;
    
        return $this;
    }

    /**
     * Remove items
     *
     * @param CO\EShopBundle\Entity\OrderItem $items
     */
    public function removeItem(\CO\EShopBundle\Entity\OrderItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return text
     */
	public function getObs() {
		return $this->obs;
	}

    /**
     * @param string $obs
     * @return User
     */
	public function setObs($obs) {
		$this->obs = $obs;
	}
	

    /**
     * @return text
     */
	public function getCancelObs() {
		return $this->cancelObs;
	}

    /**
     * @param string $obs
     * @return User
     */
	public function setCancelObs($obs) {
		$this->cancelObs = $obs;
	}
}