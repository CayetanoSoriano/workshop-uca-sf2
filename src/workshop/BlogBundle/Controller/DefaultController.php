<?php

namespace workshop\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use workshop\BlogBundle\Entity\Post;
use workshop\BlogBundle\Entity\Category;
use Faker\Factory;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {

    	$em = $this->getDoctrine()->getEntityManager();
    	$faker = Factory::create();



    	$post = new Post();
    	$post->setTitle($faker->text(15))
    	     ->setText($faker->text(4000))
    	;


        $category = new Category();
        $category->setName($faker->text(10));
        $post->setCategory($category);
        $category->addPost($post); 
        $em->persist($category);
    	$em->persist($post);



    	$em->flush();

    	$posts = $em->getRepository('workshopBlogBundle:Post')->findAll();
        $categories = $em->getRepository('workshopBlogBundle:Category')->findAll();
    	return array('posts' => $posts,'categories' => $categories);
    }
}
