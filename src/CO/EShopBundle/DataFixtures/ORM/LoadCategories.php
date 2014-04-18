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
		
        $entity = new Category();
        $entity->setName('Casual');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityShoes);

        $manager->persist($entity);
		
        $entity = new Category();
        $entity->setName('Sport');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityShoes);

        $manager->persist($entity);
		
        $entity = new Category();
        $entity->setName('Boots');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityShoes);

        $manager->persist($entity);
		
		// ------------------------
		
        $entityShoes = new Category();
        $entityShoes->setName('Long Sleeves');
        $entityShoes->setMetadescription('generic metadescription');
        $entityShoes->setMetakeywords('generic metakeywords');

        $manager->persist($entityShoes);		

        $entity = new Category();
        $entity->setName('Shirts');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');

        $manager->persist($entity);

        $entityJeans = new Category();
        $entityJeans->setName('Jeans');
        $entityJeans->setMetadescription('generic metadescription');
        $entityJeans->setMetakeywords('generic metakeywords');

        $manager->persist($entityJeans);

        $entity = new Category();
        $entity->setName('Straight');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityJeans);

        $manager->persist($entity);
		
        $entity = new Category();
        $entity->setName('Skiny');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityJeans);

        $manager->persist($entity);
		
        $entity = new Category();
        $entity->setName('Hip');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityJeans);

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