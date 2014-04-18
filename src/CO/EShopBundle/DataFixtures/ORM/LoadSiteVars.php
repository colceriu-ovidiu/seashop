<?php
namespace CO\EShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CO\EShopBundle\Entity\SiteVar;

class LoadSiteVarsData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new SiteVar();
        $entity->setName('_site_name');
		$entity->setContent('Sea Shop');
		
        $manager->persist($entity);
		
        $entity = new SiteVar();
        $entity->setName('_site_company');
		$entity->setContent('Sea Shop SRL');
		
        $manager->persist($entity);
		
        $entity = new SiteVar();
        $entity->setName('_site_company_addrs');
		$entity->setContent('str. Street nr. Number ap Ap Town Postal Code');
		
        $manager->persist($entity);
		
        $entity = new SiteVar();
        $entity->setName('_site_company_bank');
		$entity->setContent('Bank');
		
        $manager->persist($entity);
		
        $entity = new SiteVar();
        $entity->setName('_site_company_cont');
		$entity->setContent('ROAABBCCDD');
		
        $manager->persist($entity);
		
        $entity = new SiteVar();
        $entity->setName('_site_company_phone');
		$entity->setContent('07123456789');
		
        $manager->persist($entity);
		
        $entity = new SiteVar();
        $entity->setName('_site_admin_email');
		$entity->setContent('office@seashop.ro');
		
        $manager->persist($entity);
		
        $entity = new SiteVar();
        $entity->setName('_site_admin_from');
		$entity->setContent('webmin sea-shop');
		
        $manager->persist($entity);
		
        $manager->flush();
    }
	
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }	
}