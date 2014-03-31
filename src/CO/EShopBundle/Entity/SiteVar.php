<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * TSC\WebsiteBundle\Entity\SiteVar
 *
 * @ORM\Table("site_vars")
 * @ORM\Entity(repositoryClass="CO\EShopBundle\Entity\SiteVarRepository")
 */
class SiteVar
{
	
		const SITE_NAME = '_site_name';
		const SITE_COMPANY = '_site_company';
		const SITE_COMPANY_ADDRS = '_site_company_addrs';
		const SITE_COMPANY_BANK = '_site_company_bank';
		const SITE_COMPANY_CONT = '_site_company_cont';
		const SITE_COMPANY_PHONE = '_site_company_phone';
		const SITE_ADMIN_EMAIL = '_site_admin_email';
		const SITE_ADMIN_FROM = '_site_admin_from';
	
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
     * @var string $content
     *
     * @ORM\Column(name="content", type="string")
     */
    private $content;


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
    
}