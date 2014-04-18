<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
//use Gedmo\Translatable\Translatable;

/**
 * TSC\WebsiteBundle\Entity\Page
 *
 * @ORM\Table("page")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\PageRepository")
 */
class Page
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
     * @var text $content
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var text $metadescription
     *
     * @ORM\Column(name="metadescription", type="text")
     */
    private $metadescription;

    /**
     * @var text $metakeywords
     *
     * @ORM\Column(name="metakeywords", type="text")
     */
    private $metakeywords;    



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
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set metadescription
     *
     * @param text $metadescription
     */
    public function setMetadescription($metadescription)
    {
        $this->metadescription = $metadescription;
    }

    /**
     * Get metadescription
     *
     * @return text 
     */
    public function getMetadescription()
    {
        return $this->metadescription;
    }
    
    /**
     * Set metakeywords
     *
     * @param text $metakeywords
     */
    public function setMetakeywords($metakeywords)
    {
        $this->metakeywords = $metakeywords;
    }

    /**
     * Get metakeywords
     *
     * @return text 
     */
    public function getMetakeywords()
    {
        return $this->metakeywords;
    }    


    
}