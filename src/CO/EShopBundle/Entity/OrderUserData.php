<?php
namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CO\EShopBundle\Entity\OrderUserData
 * @ORM\Entity
 * @ORM\Table(name="order_user_data")
 */
class OrderUserData
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $email;
	
    /**
     * @ORM\Column(type="string", length=200)
     */
	private $fullname;
	
    /**
     * @ORM\Column(type="string", length=100)
     */
	private $phone;

	/**
     * @ORM\Column(type="smallint")
     */
	private $perstype;
	
	/**
     * @ORM\Column(type="text")
     */
	private $addrsship;


    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
	
    /**
     * @return string 
     */
	public function getFullname() {
	}
    /**
     * @param string $fullname
     * @return User
     */
	public function setFullname($fullname) {
        $this->fullname = $fullname;
    
        return $this;
	}
	
    /**
     * @return string 
     */
	public function getPhone() {
	}
    /**
     * @param string $phone
     * @return User
     */
	public function setPhone($phone) {
        $this->phone = $phone;
    
        return $this;
	}
	
    /**
     * @return smallint
     */
	public function getPerstype() {
	}
    /**
     * @param string $perstype
     * @return User
     */
	public function setPerstype($perstype) {
        $this->perstype = $perstype;
    
        return $this;
	}
	
    /**
     * @return text
     */
	public function getAddrsship() {
	}
    /**
     * @param string $addrsship
     * @return User
     */
	public function setAddrsship($addrsship) {
        $this->addrsship = $addrsship;
    
        return $this;
	}
	
}