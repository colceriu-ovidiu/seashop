<?php
namespace CO\EShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CO\EShopBundle\Entity\Product;

class LoadProducts extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entityProduct = new Product();
        $entityProduct->setCategory($this->getReference('cat_shoes'));
        $entityProduct->setName('Shoes');
        $entityProduct->setPrice(10.5);
        //$entityProduct->finalPrice(10.5);
        $entityProduct->setShortdesc("short desc");
        $entityProduct->setDescription("desc");
        $entityProduct->setMetadescription('generic metadescription');
        $entityProduct->setMetakeywords('generic metakeywords');
        //$entityProduct->picsrc(10.5);
        //$entityProduct->pic_file(10.5);
        //$entityProduct->updated(10.5);
        //$entityProduct->banner(10.5);
        $entityProduct->setSlug('wer');
        $entityProduct->setUm('m');
        $entityProduct->setAvailable(true);        
        //$entityProduct->discount(10.5);        


        $entityProduct->setMetakeywords('generic metakeywords');

        $manager->persist($entityProduct);
		
        /*$entity = new Product();
        $entity->setName('Casual');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityShoes);

        $manager->persist($entity);
		
        $entity = new Product();
        $entity->setName('Sport');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityShoes);

        $manager->persist($entity);
		
        $entity = new Product();
        $entity->setName('Boots');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');
		$entity->setParent($entityShoes);

        $manager->persist($entity);*/
		
		// ------------------------
			
        $manager->flush();
    }
	
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }	
}