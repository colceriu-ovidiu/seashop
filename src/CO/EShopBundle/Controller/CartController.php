<?php

namespace CO\EShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CO\EShopBundle\Entity\Order;
use CO\EShopBundle\Entity\OrderItem;
use CO\EShopBundle\Entity\OrderUserData;
use CO\EShopBundle\Entity\Flags\OrderStatus;
use CO\EShopBundle\Entity\User;
use CO\EShopBundle\Form\RegUserType;



/**
 * @Route("/members/cart")
 */
class CartController extends UberController
{
	/**
  * @Route("/", name="_cart")
	* @Template()
  */
	public function indexAction()
	{
		$session = $this->getRequest()->getSession();
		$cart = $session->get('cart', array());
		
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('COEShopBundle:Product');
		
		$items = array();
		foreach ($cart as $id => $qty) {
			$item = array();
			$item['id'] = $id;
			$item['qty'] = $qty;
			$item['prod'] = $repo->find($id);
			$items[] = $item;
		}
		
		$shipping_methods = $em->getRepository('COEShopBundle:ShippingMethod')->findAll();
		
		$user = $this->getUser(); 
		if ($user==null) {
		    $user = new User();
		    $user->setPerstype(1);
		    $form_register   = $this->createForm(new RegUserType(), $user)->createView();
		} else {
		    $form_register = null;
		}
		
		
		return array(
				'cat_id'=>0,
				'items'=>$items,
				'shipping_methods'=>$shipping_methods,
				'back_url'=> $this->getRequest()->headers->get('referer'),
				'form_register'=>$form_register,
		);
	}
	
	/**
  * @Route("/add", name="_cart_add")
  */
	public function addAction()
	{
		$request = $this->getRequest();
		
		/*if ($this->getUser()==null) {
			$this->get('session')->setFlash('notice', 'Trebuie sa fi logat pentru a face cumparaturi!');
			$referer = $request->headers->get('referer');
			return $this->redirect($referer);
		}*/
		
		$session = $this->getRequest()->getSession();
		$cart = $session->get('cart', array());

		$id = $request->request->get('prod_id');
		$qty = $request->request->get('qty');
		
		if (!isset($cart[$id])) {
			$cart[$id] = 0;
		}
		
		$cart[$id] += $qty;
		
		$session->set('cart', $cart);		
		
		return $this->redirect($this->generateUrl('_cart'));
	}

	/**
	 * @Route("/remove/{id}", name="_cart_remove")
	 */
	public function removeAction($id)
	{	
		$session = $this->getRequest()->getSession();
		$cart = $session->get('cart', array());
		
		unset($cart[$id]);
		
		$session->set('cart', $cart);		
		
		return $this->redirect($this->generateUrl('_cart'));
	}	
	
	
	/**
	 * @Route("/checkout", name="_cart_checkout")
	 */
	public function checkoutAction(Request $request)
	{
		$referer = $request->headers->get('referer');
		
		// get cart from session
		$session = $this->getRequest()->getSession();
		$cart = $session->get('cart', array());
		
		// create order
		$em = $this->getDoctrine()->getManager();
		
                $order = new Order();
                $order->setStatus(OrderStatus::STATUS_NEW);

                // get logged user
		$user = $this->getUser(); 
		if ($user!=null) {
			// create order
			$order->setUser($user);
		} else {
			$newuser = new User();
			$userForm = $this->createForm(new RegUserType(), $newuser);
		    
			$request = $this->getRequest();
			$userForm->bindRequest($request);
			if (!$userForm->isValid()) {
			    // throw error
			    print_r( $userForm->getErrors() );
			    //return $this->redirect($this->generateUrl('_cart'));
			}
			
			if ($this->checkExistUser($newuser)) {
				return new RedirectResponse($referer);
			}
			
			$newuser->setUsername($newuser->getEmail());

			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($newuser);			
		    
			$order->setUser($newuser);
		}
		
		// add items to order		
		$total = 0;
		$repoProduct = $em->getRepository('COEShopBundle:Product');
		foreach ($cart as $id => $qty) {
			$prod = $repoProduct->find($id);
			$orderItem = new OrderItem();
			$orderItem->setProduct($prod);
			$orderItem->setPrice($prod->getFinalPrice());
			$orderItem->setQty($qty);
			$subtotal = $qty * $prod->getFinalPrice();
			$orderItem->setTotal($subtotal);
			$orderItem->setOrder($order);
			
			$total += $subtotal;
			
			$order->getItems()->add($orderItem);
		}

		$order->setTotal($total);

		$orderClient = new OrderUserData();
		if ($user!=null) {
			$dbuser = $em->getRepository('COEShopBundle:User')->findOneById($user->getId());
		} else {
			$dbuser = $newuser;
		}
		$orderClient->setUsername($dbuser->getUsername());
		$orderClient->setEmail($dbuser->getEmail());
		$orderClient->setFullname($dbuser->getFullname());
		$orderClient->setPhone($dbuser->getPhone());
		$orderClient->setPerstype($dbuser->getPerstype());
		$orderClient->setAddrsship($dbuser->getAddrsship());
		$em->persist($orderClient);

		$order->setOrderUserData($orderClient);
		
		// set shipping
		$shipping_id = $this->get('request')->request->get('shipping_method');
		$order->setShippingcomp($shipping_id);

		$em->persist($order);
		$em->flush();
		
		$params = array(
			"order_id"=>$order->getId(),
			"order_createTimestamp"=>$order->getCreateTimestamp(),
			"user_fullname"=>$dbuser->getFullname(),
			"user_email"=>$dbuser->getEmail(),
			"user_phone"=>$dbuser->getPhone(),
			"order_addrsship"=>$order->getOrderUserData()->getAddrsship(),
			"order_total"=>$order->getTotal(),
			"order_items"=>$order->getItems(),
			);
		$this->sendMail(self::MAIL_TYPE_SEND_ORDER, $params);
		
		// reset cart
		$session->set('cart', array());
		
		// redirect
		return $this->redirect($this->generateUrl('_cart_checkout_complete'));
	}


	/**
	* @Route("/checkout_complete", name="_cart_checkout_complete")
	* @Template()
	*/
	public function checkoutCompleteAction()
	{
		$session = $this->getRequest()->getSession();
		$cart = $session->get('cart', array());
		
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('COEShopBundle:Product');
		
		$items = array();
		foreach ($cart as $id => $qty) {
			$item = array();
			$item['id'] = $id;
			$item['qty'] = $qty;
			$item['prod'] = $repo->find($id);
			$items[] = $item;
		}
		
		return array(
				'cat_id'=>0,
				'items'=>$items
		);
	}

	/**
	 * @Template()
	 */
	public function amountAction()
	{	
		// get cart from session
		$session = $this->getRequest()->getSession();
		$cart = $session->get('cart', array());
		
		$amount = 0;
		foreach ($cart as $id => $qty) {
			$amount += $qty;
		}
		
		return array(
			'amount'=>$amount
		);
	}	

	
}
