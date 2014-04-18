<?php

namespace CO\EShopBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
	
	public function getParentsQB() {
		//return $this->findByParent(null);
		return $this->getEntityManager()
						->createQueryBuilder()
							->select('c')
							->from('COEShopBundle:Category', 'c')
							->where('c.parent IS NULL')
							->orderBy('c.name', 'ASC');
	}
	
}