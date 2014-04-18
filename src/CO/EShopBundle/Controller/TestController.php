<?php
namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use CO\EShopBundle\Entity\User;

class TestController extends Controller
{
	/**
	* @Route("/test", name="_test")
	*/
	public function testAction()
	{
		$factory = $this->get('security.encoder_factory');
		$user = new User; //__construct automatically creates salt

		$encoder = $factory->getEncoder($user);
		$password = $encoder->encodePassword('user123', 'abc');
		echo 'salt: '.$user->getSalt();
		echo '<br />pass: '.$password;		
	}
}
