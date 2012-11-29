<?php

namespace workshop\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{

	public function queryAllOrderByDate()
	{
		$em = $this->getEntityManager();
		$dql = 'SELECT p From workshopBlogBundle:Post p ORDER BY p.date DESC';
        return $em->createQuery($dql);
	}

	public function findAllOrderByDate()
	{
        return $this->queryAllOrderByDate()->getResult();
	}
}
