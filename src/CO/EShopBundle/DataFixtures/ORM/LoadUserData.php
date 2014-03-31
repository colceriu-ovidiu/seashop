<?php
namespace CO\EShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CO\EShopBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setPerstype(User::TYPE_PERSON);
        $user->setUsername('customer');
        $user->setEmail('customer@seashop.com');
        $user->setPassword('customer123');

        $user->setAddress('some address');
        $user->setPostalcode('122332');
		
        $manager->persist($user);
        $manager->flush();
    }
}