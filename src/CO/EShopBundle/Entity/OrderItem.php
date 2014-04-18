<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CO\EShopBundle\Entity\OrderItem
 *
 * @ORM\Table("order_items")
 * @ORM\Entity()
 */
class OrderItem 
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
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
     */
     protected $order;              
	
    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
     protected $product;

		 /**
     * @var float $price
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
   
    /**
     * @var integer $qty
     *
     * @ORM\Column(name="qty", type="integer")
     */
    private $qty;

    /**
     * @var float $total
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;
   

    /**
     * Set price
     *
     * @param float $price
     * @return OrderItem
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
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
     * Set qty
     *
     * @param integer $qty
     * @return OrderItem
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    
        return $this;
    }

    /**
     * Get qty
     *
     * @return integer 
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return OrderItem
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
     * Set order
     *
     * @param CO\EShopBundle\Entity\Order $order
     * @return OrderItem
     */
    public function setOrder(\CO\EShopBundle\Entity\Order $order)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return CO\EShopBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
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
     * Set product
     *
     * @param CO\EShopBundle\Entity\Product $product
     * @return OrderItem
     */
    public function setProduct(\CO\EShopBundle\Entity\Product $product)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return CO\EShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}