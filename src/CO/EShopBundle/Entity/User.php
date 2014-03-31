<?php
namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CO\EShopBundle\Entity\User
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
	const TYPE_PERSON = 1;
	const TYPE_COMPANY = 2;
	
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
	 * @Assert\Email()
     */
    private $email;
	
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Assert\NotBlank(groups={"person"})
     */
	private $fullname;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
	 * @Assert\NotBlank(groups={"person"})
     */
    private $phone;

    /**
     * @ORM\Column(type="text")
     */
    private $address; // judet, sector, localitate, strada, ap, scara, bloc, numar 

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $obs;

	/**
     * @ORM\Column(type="smallint")
     */
	private $perstype;
	
	/**
     * @ORM\Column(type="text", nullable=true)
     */
	private $addrsship;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
	 * @Assert\NotBlank(groups={"company"})
     */
    private $compName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
	 * @Assert\NotBlank(groups={"company"})
     */
    private $compFiscalCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
	 * @Assert\NotBlank(groups={"company"})
     */
    private $compNrReg;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
	 * @Assert\NotBlank(groups={"company"})
     */
    private $compPersName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
	 * @Assert\NotBlank(groups={"company"})
     */
    private $compPersPhone;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
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
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
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
        return $this->fullname;
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
        return $this->phone;
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
        return $this->perstype;
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
        return $this->addrsship;
	}
    /**
     * @param string $addrsship
     * @return User
     */
	public function setAddrsship($addrsship) {
        $this->addrsship = $addrsship;
    
        return $this;
	}
	
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return User
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    
        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set obs
     *
     * @param string $obs
     * @return User
     */
    public function setObs($obs)
    {
        $this->obs = $obs;
    
        return $this;
    }

    /**
     * Get obs
     *
     * @return string 
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * Set compName
     *
     * @param string $compName
     * @return User
     */
    public function setCompName($compName)
    {
        $this->compName = $compName;
    
        return $this;
    }

    /**
     * Get compName
     *
     * @return string 
     */
    public function getCompName()
    {
        return $this->compName;
    }

    /**
     * Set compFiscalCode
     *
     * @param string $compFiscalCode
     * @return User
     */
    public function setCompFiscalCode($compFiscalCode)
    {
        $this->compFiscalCode = $compFiscalCode;
    
        return $this;
    }

    /**
     * Get compFiscalCode
     *
     * @return string 
     */
    public function getCompFiscalCode()
    {
        return $this->compFiscalCode;
    }

    /**
     * Set compNrReg
     *
     * @param string $compNrReg
     * @return User
     */
    public function setCompNrReg($compNrReg)
    {
        $this->compNrReg = $compNrReg;
    
        return $this;
    }

    /**
     * Get compNrReg
     *
     * @return string 
     */
    public function getCompNrReg()
    {
        return $this->compNrReg;
    }

    /**
     * Set compPersName
     *
     * @param string $compPersName
     * @return User
     */
    public function setCompPersName($compPersName)
    {
        $this->compPersName = $compPersName;
    
        return $this;
    }

    /**
     * Get compPersName
     *
     * @return string 
     */
    public function getCompPersName()
    {
        return $this->compPersName;
    }

    /**
     * Set compPersPhone
     *
     * @param string $compPersPhone
     * @return User
     */
    public function setCompPersPhone($compPersPhone)
    {
        $this->compPersPhone = $compPersPhone;
    
        return $this;
    }

    /**
     * Get compPersPhone
     *
     * @return string 
     */
    public function getCompPersPhone()
    {
        return $this->compPersPhone;
    }
}