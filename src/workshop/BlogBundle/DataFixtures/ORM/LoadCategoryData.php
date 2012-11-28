<?php

namespace workshop\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use workshop\BlogBundle\Entity\Category;
use Faker\Factory;
use \Doctrine\Common\Collections\ArrayCollection;

/**
* Class X
*/
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$faker = Factory::create();

		$category = new Category();

		$category->setName($faker->text(15));
		$manager->persist($category);

		$manager->flush();
		$this->addReference('categoria',$category);
	}

   public function getOrder()
    {
        return 3;
    }
}