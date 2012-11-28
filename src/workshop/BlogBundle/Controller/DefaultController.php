<?php

namespace workshop\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    	$posts = $em->getRepository('workshopBlogBundle:Post')->findAll();
    	return compact('posts');
    }


    /**
     * @Route("/category/{slug}", name="_BlogCategory")
     * @Template("workshopBlogBundle:Default:index.html.twig")
     */
    public function categoryAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $category = $em->getRepository('workshopBlogBundle:Category')->findOneBySlug($slug);
        $posts = $category->getPosts();

        return compact('posts');
    }



    /**
     * @Route("/{slug}", name="_BlogView")
     * @Template()
     */
    public function viewAction($slug)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $post = $em->getRepository('workshopBlogBundle:Post')->findOneBySlug($slug);
        if(!$post) {
            throw new NotFoundHttpException('The specified entity does not exist.');
        }

        return array('post' => $post,'comments' => $post->getComments());
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $categories = $em->getRepository('workshopBlogBundle:Category')->findAll();
        return $this->render('workshopBlogBundle:Default:sidebar.html.twig',
            array('categories' => $categories)
        );
    }
}
