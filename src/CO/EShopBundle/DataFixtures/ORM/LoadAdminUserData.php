<?php
namespace CO\EShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CO\EShopBundle\Entity\AdminUser;

class LoadAdminUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new AdminUser();
        $userAdmin->setUsername('admin');
		$userAdmin->setEmail('admin@admin.com');
        $userAdmin->setPassword('admin123');

        $manager->persist($userAdmin);
		
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