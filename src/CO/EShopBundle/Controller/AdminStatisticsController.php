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
 * @Route("/admin/statistics")
 */
class AdminStatisticsController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="admin_statistics")
     * @Template
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder()
                            ->select('count(oi.qty) as nr, sum(oi.qty) as totalqty, p.name as prod_name')
                            ->from('COEShopBundle:OrderItem', 'oi')
                            ->innerjoin('oi.product', 'p')
                            ->groupBy('p.id')
                            ->orderBy('nr', 'DESC');

        $res = $qb->getQuery()->getResult();

        return array(
            'res' => $res,
        );
    }


}
