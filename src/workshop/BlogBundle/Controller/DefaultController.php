<?php

namespace workshop\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use workshop\BlogBundle\Entity\Post;
use workshop\BlogBundle\Entity\Category;
use workshop\BlogBundle\Entity\Comment;
use workshop\BlogBundle\Form\PostType;
use workshop\BlogBundle\Form\CommentType;
use workshop\BlogBundle\Form\ViewCommentType;
use Faker\Factory;

class DefaultController extends Controller
{
    /**
     * @Route("/", name ="_homepage")
     * @Template()
     */
    public function indexAction()
    {

    	$em = $this->getDoctrine()->getEntityManager();
        $query = $em->getRepository('workshopBlogBundle:Post')->queryAllOrderByDate();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1)/*page number*/,
            1/*limit per page*/
            );


        return compact('pagination');
    }



    /**
     * @Route("/admin/")
     * @Template()
     */
    public function adminAction()
    {
        return array();
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
     * @Route("/comment/save/", name="_BlogCommentSave")
     * @Template()
     * @Method("POST")
     */
    public function CommentSaveAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);
        $form->bind($this->getRequest());
        $this->get('ladybug')->log($this->getRequest());

        if($form->isValid()) {
         $this->get('session')->setFlash(
            'message',
            'Your Comment was saved!'
            );
         $em->persist($comment);
         $em->flush();
     }


     return $this->redirect($this->generateUrl("_BlogView",array('slug'=>$comment->getPost()->getSlug())));
 }


    /**
     * @Route("/{slug}", name="_BlogView")
     * @Template()
     * @Method("GET")
     */
    public function viewAction($slug)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $post = $em->getRepository('workshopBlogBundle:Post')->findOneBySlug($slug);
        if(!$post) {
            throw new NotFoundHttpException('The specified entity does not exist.');
        }

        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(new ViewCommentType(), $comment);

        return array('post' => $post,'comments' => $post->getComments(), 'form' => $form->createView());
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
