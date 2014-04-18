<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\Product;
use CO\EShopBundle\Form\ProductType;
use CO\EShopBundle\Entity\Flags\OrderStatus;

/**
 * Product controller.
 *
 * @Route("/admin/order")
 */
class AdminOrderController extends UberController
{
    /**
     * Lists all Product entities.
     *
     * @Route("/{status}", name="admin_orders", defaults={"status"=0})
     * @Route("/", defaults={"status"=0}, name="admin_orders_list")
     * @Template()
     */
    public function indexAction($status)
    {
        $em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository('COEShopBundle:Order')->getItems($status);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="admin_order_edit")
     * @Template()
     */
    public function editAction($id)
    {
				if ($id>0) {
					$em = $this->getDoctrine()->getManager();
					$entity = $em->getRepository('COEShopBundle:Order')->find($id);
					if (!$entity) {
							throw $this->createNotFoundException('Unable to find Product entity.');
					}
				} else {
					$entity  = new Order();
				}
			
        $editForm = $this->createForm(new ProductType(), $entity);

				$request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
        	$editForm->bindRequest($request);
					if ($editForm->isValid()) {
						$em = $this->getDoctrine()->getEntityManager();
        		$em->persist($entity);
        		$em->flush();
        
        		$this->get('session')->setFlash('notice', 'Product '.$entity->getName().' was added');
						
						return $this->redirect($this->generateUrl('admin_product'));
					}
				}
				
        return array(
            'entity'      => $entity,
            'id'      => $id,
            'edit_form'   => $editForm->createView()
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/show", name="admin_order_show")
     * @Template()
     */
    public function showAction($id)
    {
				$em = $this->getDoctrine()->getManager();
				$order = $em->getRepository('COEShopBundle:Order')->find($id);
				if (!$order) {
						throw $this->createNotFoundException('Unable to find Order entity.');
				}
				// OBS: order_user_data not used anymore - will be used in future
				
				$shipping_ent = $em->getRepository('COEShopBundle:ShippingMethod')->find( $order->getShippingcomp() );
				$shippingcomp_name = $shipping_ent->getName();
				
				$new_status = ($order->getStatus()<4) ? $order->getStatus()+1 : 0;
			
        return array(
            'order' => $order,
            'id' => $id,
			'shippingcomp_name' => $shippingcomp_name,
			'new_status' => $new_status,
			'status_canceled' => OrderStatus::STATUS_CANCELED,
			'input_awb' => $order->getStatus()==OrderStatus::STATUS_CONFIRMED,
			'show_awb' => in_array($order->getStatus(), array(OrderStatus::STATUS_SHIPED, OrderStatus::STATUS_ARRIVED))
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/status", name="admin_order_status")
     */
    public function statusAction($id)
    {
				$em = $this->getDoctrine()->getManager();
				$order = $em->getRepository('COEShopBundle:Order')->find($id);
				if (!$order) {
						throw $this->createNotFoundException('Unable to find Order entity.');
				}
				
				$request = $this->getRequest();
                $new_status = $request->request->get('new_status');

                // NEW -> CONFIRMED
                if ( ($order->getStatus()==OrderStatus::STATUS_NEW) && 
                     ($new_status==OrderStatus::STATUS_CONFIRMED) ) 
                {
                    // send confirmations mail
                    $params = array(
                        "order_id"=>$order->getId(),
                        "order_createTimestamp"=>$order->getCreateTimestamp(),
                        "user_fullname"=>$order->getUser()->getFullname(),
                        "user_email"=>$order->getUser()->getEmail(),
                        "user_phone"=>$order->getUser()->getPhone(),
                        "order_addrsship"=>$order->getOrderUserData()->getAddrsship(),
                        "order_total"=>$order->getTotal(),
                        );
                    $this->sendMail(self::MAIL_TYPE_SEND_CONFIRM_ORDER, $params);
                } else
                // CONFIRMED -> SHIPED
				if ($order->getStatus()==OrderStatus::STATUS_CONFIRMED) {
					$awb = $request->request->get('awb');
					$order->setAwb($awb);

                    // send shipped
                    $params = array(
                        "order_id"=>$order->getId(),
                        "order_createTimestamp"=>$order->getCreateTimestamp(),
                        "user_fullname"=>$order->getUser()->getFullname(),
                        "user_email"=>$order->getUser()->getEmail(),
                        "user_phone"=>$order->getUser()->getPhone(),
                        "order_addrsship"=>$order->getOrderUserData()->getAddrsship(),
                        "order_total"=>$order->getTotal(),
                        "order_awb"=>$order->getAwb(),
                        );
                    $this->sendMail(self::MAIL_TYPE_SEND_SHIP_ORDER, $params);
				} else 
				if ($new_status==OrderStatus::STATUS_CANCELED) {
					$order->setCancelObs( $request->request->get('cancel_obs') );
				}
				
		
				$order->setStatus($new_status);

				$em->persist($order);
				$em->flush();
				
				$this->get('session')->setFlash('notice', 'Status was added changed');
			
				return $this->redirect($this->generateUrl('admin_order_show', array('id' => $id)));
    }

}
