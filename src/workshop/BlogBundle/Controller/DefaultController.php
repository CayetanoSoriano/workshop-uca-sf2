<?php

namespace workshop\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use workshop\BlogBundle\Entity\Post;
use Faker\Factory;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}/")
     * @Template()
     */
    public function indexAction($name)
    {

    	$em = $this->getDoctrine()->getEntityManager();
    	$faker = Factory::create('es_ES');



    	$post = new Post();
    	$post->setTitle($faker->text(15))
    	->setText($faker->text(4000))
    	->setSlug($post->getTitle())
    	//->setDate(new \DateTime())
    	;

    	var_dump($post);
    	$em->persist($post);
    	$em->flush();

    	$posts = $em->getRepository('workshopBlogBundle:Post')->findAll();
    	return array('posts' => $posts);
    }
}
