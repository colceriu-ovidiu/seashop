<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * TSC\WebsiteBundle\Entity\NewsletterSession
 *
 * @ORM\Table("newsletter_sessions")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks 
 */
class NewsletterSession
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
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="newsletternession")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", nullable=false)
     */
     protected $newsletter; 

    /**
     * @var datetime $createTimestamp
     *
     * @ORM\Column(name="create_timestamp", type="datetime", nullable=false)
     */
    private $createTimestamp;


/*-----------------------------------------------------------------*/

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreateTimestamp(new \DateTime());
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
     * Set user
     *
     * @param CO\EShopBundle\Entity\Newsletter $newsletter
     * @return NewsletterSession
     */
    public function setNewsletter(\CO\EShopBundle\Entity\Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    
        return $this;
    }

    /**
     * Get newsletter
     *
     * @return CO\EShopBundle\Entity\Newsletter 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
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

    
}