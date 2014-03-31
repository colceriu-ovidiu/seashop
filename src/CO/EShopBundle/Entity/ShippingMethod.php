<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CO\EShopBundle\Entity\ShippingMethod
 *
 * @ORM\Table("shipping_methods")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\ShippingMethodRepository")
 */
class ShippingMethod
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

		 
//-----------------------------------------------------------      

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


}