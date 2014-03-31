<?php
namespace CO\ArticlesBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 */
class ArticleRepository extends EntityRepository
{
    public function getLatestBlogs($limit = null)
    {
        $qb = $this->createQueryBuilder('a')
                   //->addSelect('c')
				   ->leftJoin('a.comments', 'c')
                   ->addOrderBy('a.created', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()
                  ->getResult();
    }

    public function getLatestBlog()
    {
        $qb = $this->createQueryBuilder('a')
                   ->addOrderBy('a.created', 'DESC');
		$qb->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }
	
	public function getTags()
	{
		$articleTags = $this->createQueryBuilder('a')
						 ->select('a.tags')
						 ->getQuery()
						 ->getResult();

		$tags = array();
		foreach ($articleTags as $articleTag)
		{
			$tags = array_merge(explode(",", $articleTag['tags']), $tags);
		}

		foreach ($tags as &$tag)
		{
			$tag = trim($tag);
		}

		return $tags;
	}
	
	public function getTagWeights($tags)
	{
		$tagWeights = array();
		if (empty($tags))
			return $tagWeights;

		foreach ($tags as $tag)
		{
			$tagWeights[$tag] = (isset($tagWeights[$tag])) ? $tagWeights[$tag] + 1 : 1;
		}
		// Shuffle the tags
		uksort($tagWeights, function() {
			return rand() > rand();
		});

		$max = max($tagWeights);

		// Max of 5 weights
		$multiplier = ($max > 5) ? 5 / $max : 1;
		foreach ($tagWeights as &$tag)
		{
			$tag = ceil($tag * $multiplier);
		}

		return $tagWeights;
	}	
}