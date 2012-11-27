<?php

namespace workshop\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections;

use workshop\BlogBundle\Entity\Post;
use Faker\Factory;


/**
* Class X
*/
class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$faker = Factory::create();
		
		
		$post = new Post();
		$post->setCategory($this->getReference('categoria'))
			 ->setTitle($faker->text(15))
			 ->setText($faker->text(15))
		;

		$manager->persist($post);
		$manager->flush();

		$this->addReference('post',$post);

		


	}

   public function getOrder()
    {
        return 4;
    }
}