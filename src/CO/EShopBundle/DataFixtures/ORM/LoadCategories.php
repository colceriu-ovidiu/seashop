<?php
namespace CO\EShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CO\EShopBundle\Entity\Category;

class LoadCategories implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entityShoes = new Category();
        $entityShoes->setName('Shoes');
        $entityShoes->setMetadescription('generic metadescription');
        $entityShoes->setMetakeywords('generic metakeywords');

        $manager->persist($entityShoes);
		
        $entityShoes = new Category();
        $entityShoes->setName('Long Sleeves');
        $entityShoes->setMetadescription('generic metadescription');
        $entityShoes->setMetakeywords('generic metakeywords');

        $manager->persist($entityShoes);		

        $entity = new Category();
        $entity->setName('Shirts');
		$entity->setContent('generic content');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');

        $manager->persist($entity);

        $entity = new Category();
        $entity->setName('Jeans');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');

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