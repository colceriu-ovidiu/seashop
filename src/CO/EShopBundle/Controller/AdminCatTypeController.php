<?php

namespace CO\EShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\EShopBundle\Entity\CatType;
//use CO\EShopBundle\Form\CatTypeType;

/**
 * Product controller.
 *
 * @Route("/admin/cattype")
 */
class AdminCatTypeController extends AdminUberController
{
	
	public function __construct()
	{
		$this->entityName = 'COEShopBundle:CatType';
		$this->itemName = 'CatType';
		$this->entityFresh = new CatType();
		//$this->formType = new EntityType();
		$this->routeListing = 'admin_cattype';
		$this->curr_menu = 'catalog';
	}

    /**
     * Lists all Product entities.
     *
     * @Route("/", name="admin_cattype")
     */
    public function indexAction()
    {
        return parent::indexAction();
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="admin_cattype_edit")
     * @Template()
     */
    public function editAction($id)
    {
		return parent::editAction($id);
	}

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}/delete", name="admin_product_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        parent::deleteAction();
    }

}
