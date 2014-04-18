<?php
namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\Security\Core\SecurityContext;
//use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use CO\EShopBundle\Entity\SiteVar;




class UberController extends Controller
{
	const MAIL_TYPE_REGISTER = 1;
	const MAIL_TYPE_SEND_ORDER = 2;
	const MAIL_TYPE_SEND_CONFIRM_ORDER = 3;
	const MAIL_TYPE_SEND_SHIP_ORDER = 4;
	const MAIL_TYPE_FORGOTPASS = 5;
	const MAIL_TYPE_CONTACT = 6;

	var $config = array(
		'site_name'=>'SeaShop',
		'site_address'=>'www....ro',
		'contact_mail'=>'office@pseashop.com',
		);

	public function sendMail($mail_type, $params)
	{
		$repositoryVars = $this->getDoctrine()->getRepository('COEShopBundle:SiteVar');

			$message = \Swift_Message::newInstance()
					->setFrom($this->container->getParameter('email_from'))
			;

		$sendBCC = true;

		if ($mail_type==self::MAIL_TYPE_REGISTER) {
			$user = $params['user'];
			$mail_body = $this->renderView('COEShopBundle:Email:registerEmail.txt.twig', 
						array(
							'reply_email' => 'office@pretioasa.ro',
							'user'=>$user, 
							'user_password'=>$params['password']
						)
					);
			

			$message = \Swift_Message::newInstance()
					->setSubject('Utilizator nou')
					->setFrom('office@pretioasa.ro')
					->setTo($user->getEmail())
					->setBody($mail_body)
			;

			$this->get('mailer')->send($message);
		}
		if ($mail_type==self::MAIL_TYPE_SEND_ORDER) {
			$params_extra = $params;
			$params_extra['config'] = $this->config;

			$message = \Swift_Message::newInstance()
					->setSubject('Comanda dvs. la pretioasa.ro #'.$params['order_id'])
					->setFrom('office@pretioasa.ro')
					->setTo($params['user_email'])
					->setBody($this->renderView('COEShopBundle:Email:newOrderEmail.txt.twig', 
						$params_extra
					))
			;

			if ($sendBCC) {
				$message->addBcc( $repositoryVars->getCustomValue(SiteVar::SITE_ADMIN_EMAIL) );
			}
			
			$this->get('mailer')->send($message);
		}
		if ($mail_type==self::MAIL_TYPE_SEND_CONFIRM_ORDER) {
			$params_extra = $params;
			$params_extra['config'] = $this->config;

			// send mail to client
			$message
					->setSubject('Comanda dvs. la pretioasa.ro #'.$params['order_id'] ." a fost confirmata")
					->setTo($params['user_email'])
					->setBody($this->renderView('COEShopBundle:Email:confirmOrderEmail.txt.twig', 
						$params_extra
					))
			;
			
			
			if ($sendBCC) {
				$message->addBcc( $repositoryVars->getCustomValue(SiteVar::SITE_ADMIN_EMAIL) );
			}

			$this->get('mailer')->send($message);
		}
		if ($mail_type==self::MAIL_TYPE_SEND_SHIP_ORDER) {
			$params_extra = $params;
			$params_extra['config'] = $this->config;

			$message
					->setSubject('Comanda dvs. la pretioasa.ro #'.$params['order_id'] ." a fost trimisa")
					->setTo($params['user_email'])
					->setBody($this->renderView('COEShopBundle:Email:shipOrderEmail.txt.twig', 
						$params_extra
					))
			;

			$this->get('mailer')->send($message);
		}
		if ($mail_type==self::MAIL_TYPE_FORGOTPASS) {
			$params_extra = $params;
			$params_extra['config'] = $this->config;

			$message
					->setSubject('Parola noua la pretioasa.ro a fost trimisa')
					->setTo($params['user_email'])
					->setBody($this->renderView('COEShopBundle:Email:forgotPassEmail.txt.twig', 
						$params_extra
					))
			;

			$this->get('mailer')->send($message);
		}
		if ($mail_type==self::MAIL_TYPE_CONTACT) {
			$params_extra = $params;
			$params_extra['config'] = $this->config;

			$message
					->setSubject('Contact enquiry from symf')
					->setTo($repositoryVars->getCustomValue(SiteVar::SITE_ADMIN_EMAIL))
					->setBody($this->renderView('COEShopBundle:Email:contactEmail.txt.twig', array('enquiry' => $params_extra)))
			;

			$this->get('mailer')->send($message);
		}
		
		return true;
	}
	
	public function checkExistUser($ent) {
		$repository = $this->getDoctrine()->getRepository('COEShopBundle:User');
		$exist_user = $repository->findOneByEmail($ent->getEmail());
		if ($exist_user!=null) { // existing; 
			$this->get('session')->setFlash('notice', 'User with the email '.$ent->getEmail().' is allready registered.');
			return true;
			//return $this->redirect($this->generateUrl('_members_register'));
		} else {
			return false;
		}
	}
}
