<?php
namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use CO\EShopBundle\Entity\User;
use CO\EShopBundle\Form\UserType;
use CO\EShopBundle\Form\UserEmailType;

/**
 * @Route("/members")
 */
class MembersController extends UberController
{
	
	/**
	* @Route("/login", name="_members_login")
	* @Template()
	*/
	public function loginAction()
	{		
		$logged_user = $this->getUser();

		$is_logged = ($logged_user!=null);
		
		if (!$is_logged) {
			$request = $this->getRequest();
			$session = $request->getSession();

			// get the login error if there is one
			if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
				$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
			} else {
				$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			}
			$last_username = $session->get(SecurityContext::LAST_USERNAME);
			$logged_username = "";
		} else {
			$last_username = "";
			$logged_username = $logged_user->getUsername() ." ". $logged_user->getFullname() ." ".$logged_user->getEmail();
		}

		return array(					
            'last_username' => $last_username,
            'error'         => $error,
			'is_logged'		=> $is_logged,
		);
	}
	
	/**
	* @Route("/register", name="_members_register")
	* @Template()
	*/
	public function registerAction(Request $request)
	{
		$referer = $request->headers->get('referer');		
		
		$entity  = new User();
		
		$entity->setPersType(1); // persoana fizica

		$editForm = $this->createForm(new UserType(), $entity);

		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			$editForm->bindRequest($request);
			if ($editForm->isValid()) {
				
				if ($this->checkExistUser($entity)) {
					return new RedirectResponse($referer);
				}
				
				$raw_password = $entity->getPassword();

				$factory = $this->get('security.encoder_factory');
				$encoder = $factory->getEncoder($entity);				
				$password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());				
				$entity->setPassword($password);

				$entity->setUsername($entity->getEmail());

				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($entity);
				$em->flush();

				$params = array();
				$params['user'] = $entity;
				$params['password'] = $raw_password;
				$this->sendMail(self::MAIL_TYPE_REGISTER, $params);

				$this->get('session')->setFlash('notice', 'User '.$entity->getUserName().' was registered');

				return $this->redirect($this->generateUrl('_members_register_complete'));
				
			}
		}

		return array(
			'edit_form'   => $editForm->createView()
		);
	}
	
	/**
	* @Route("/register/complete", name="_members_register_complete")
	* @Template()
	*/
	public function registerCompleteAction()
	{
		return array(
		);
	}
	
	/**
	* @Route("/home", name="_members_home")
	* @Template()
	*/
	public function homeAction()
	{
		$user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('COEShopBundle:Order')->findByUser($user);

		$user->setPassword("");
		$persDataForm = $this->createForm(new UserType(), $user);
		
		return array(
			'persdata_form' => $persDataForm->createView(),
			'orders' => $orders,
			);
	}
	/**
	* @Route("/forgot_pass", name="_members_forgot_pass")
	* @Template()
	*/
	public function forgotpassAction()
	{
		$entity  = new User();
		$editForm = $this->createForm(new UserEmailType(), $entity);

		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			$editForm->bindRequest($request);
			if ($editForm->isValid()) {
				$repository = $this->getDoctrine()->getRepository('COEShopBundle:User');
				$exist_user = $repository->findOneByEmail($entity->getEmail());
				if ($exist_user==null) {
					$this->get('session')->setFlash('notice', 'User with the email '.$entity->getEmail().' is not registered.');
					return $this->redirect($this->generateUrl('_members_forgot_pass'));
				} else {				
					$raw_password = $this->generatePassword();
					
					$factory = $this->get('security.encoder_factory');
					$encoder = $factory->getEncoder($exist_user);				
					$password = $encoder->encodePassword($raw_password, $exist_user->getSalt());				
					$exist_user->setPassword($password);
					
					$em = $this->getDoctrine()->getEntityManager();
					$em->persist($exist_user);
					$em->flush();
					
					$params = array();
					$params['user_email'] = $exist_user->getEmail();
					$params['password'] = $raw_password;
					$this->sendMail(self::MAIL_TYPE_FORGOTPASS, $params);

					$this->get('session')->setFlash('notice', 'Parola pentru '.$exist_user->getEmail().' a fost trimisa');

					return $this->redirect($this->generateUrl('_members_forgot_pass'));
				}				
			}
			
			$error = "no error";
			
			return array(
				'edit_form'   => $editForm->createView(),
				'error'       => $error,
			);			
		}		
				
		return array(
			'edit_form'   => $editForm->createView()
		);
	}

	/**
	* @Route("/home", name="_members_save_pers_data")
	* @Template()
	*/
	public function savePersDataAction()
	{
		$user = $this->getUser();

	}
	
	/**
	* @Template()
	*/
	public function loginLinkAction()
	{
		$user = $this->getUser();
		$is_loggedin = ($user!=null);
		
		return array(					
            'is_loggedin' => $is_loggedin
		);
	}
	
	/*
	* generate random password
	*/
	private function generatePassword($length = 8) {
	    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	    $count = mb_strlen($chars);

	    for ($i = 0, $result = ''; $i < $length; $i++) {
	        $index = rand(0, $count - 1);
	        $result .= mb_substr($chars, $index, 1);
	    }

	    return $result;
	}	
	
}