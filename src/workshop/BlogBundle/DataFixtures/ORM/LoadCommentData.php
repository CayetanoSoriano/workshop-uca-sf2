<?php

namespace workshop\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections;

use workshop\BlogBundle\Entity\Comment;
use Faker\Factory;


/**
* Class X
*/
class LoadcommentData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$faker = Factory::create();
		
		
		$comment = new Comment();
		$comment->setPost($this->getReference('post'))
			 ->setText($faker->text(15))
		;

		$manager->persist($comment);
		$manager->flush();

		


	}

   public function getOrder()
    {
        return 5;
    }
}