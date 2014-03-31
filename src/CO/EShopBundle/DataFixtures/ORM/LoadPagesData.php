<?php
namespace CO\EShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CO\EShopBundle\Entity\Page;

class LoadPageData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new Page();
        $entity->setName('_home');
		$entity->setContent('generic content');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');

        $manager->persist($entity);

        $entity = new Page();
        $entity->setName('_terms');
		$entity->setContent('generic content');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');

        $manager->persist($entity);

        $entity = new Page();
        $entity->setName('_protectconsumer');
		$entity->setContent('generic content');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');

        $manager->persist($entity);

        $entity = new Page();
        $entity->setName('_links');
		$entity->setContent('generic content');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');

        $manager->persist($entity);

        $entity = new Page();
        $entity->setName('_protect');
		$entity->setContent('generic content');
        $entity->setMetadescription('generic metadescription');
        $entity->setMetakeywords('generic metakeywords');

        $manager->persist($entity);

        $entity = new Page();
        $entity->setName('_contact');
		$entity->setContent('generic contact content');
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