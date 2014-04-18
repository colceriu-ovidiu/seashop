<?php

namespace CO\EShopBundle\Entity\Flags;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderStatus
 *
 * @author Ovi
 */
class OrderStatus {
	//put your code here
	const STATUS_NEW = 1;
	const STATUS_CONFIRMED = 2; // admin calls user for confirmation
	const STATUS_SHIPED = 3; // package was sent
	const STATUS_ARRIVED = 4; // package arrived to customer and payed
	const STATUS_CANCELED = 5;
	
	public static function getC() {
		return 1;
	}
}

?>
