<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TSC\WebsiteBundle\Entity\Subscriber
 *
 * @ORM\Table("subscribers")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\SubscriberRepository")
 */
class Subscriber
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
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(
     *     message = "adresa '{{ value }}' nu e valida.",
     *     checkMX = true
     * )
     */
    private $email;


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
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
}