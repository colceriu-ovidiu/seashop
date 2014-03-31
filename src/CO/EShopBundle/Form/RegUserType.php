<?php

namespace CO\EShopBundle\Form;

use CO\EShopBundle\Form\UserType;

class RegUserType extends UserType {

	public function init() {
		$this->useCredetials = false;
	}
	
}
