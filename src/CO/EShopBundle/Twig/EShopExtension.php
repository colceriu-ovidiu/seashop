<?php

namespace CO\EShopBundle\Twig;


class EShopExtension extends \Twig_Extension	
{
    public function getFilters()
    {
        return array(
            'status' => new \Twig_Filter_Method($this, 'statusFilter'),
        );
    }

    public function statusFilter($status_nr)
    {
        switch($status_nr) {
					case 1: return "noua";
					case 2: return "confirmata";
					case 3: return "trimisa";
					case 4: return "finalizata";
					case 5: return "canceled";
					default: return "-";
				}
    }

    public function getName()
    {
        return 'eshop_extension';
    }
}

?>
