<?php

namespace workshop\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use workshop\BlogBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}/")
     * @Template()
     */
    public function indexAction($name)
    {

    	$em = $this->getDoctrine()->getEntityManager();

    	$post = new Post();
    	$post->setTitle('hola')
    	->setText('que tal')
    	->setSlug($post->getTitle())
    	->setDate(new \DateTime())
    	;

    	$em->persist($post);
    	$em->flush();

    	$posts = $em->getRepository('workshopBlogBundle:Post')->findAll();
    	return array('posts' => $posts);
    }
}
