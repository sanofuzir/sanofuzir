<?php

namespace sano\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use sano\CoreBundle\Entity\Post;
use sano\CoreBundle\Models\PostManager;
use sano\CoreBundle\Entity\Comment;
use sano\CoreBundle\Models\CommentManager;
use sano\CoreBundle\Form\CommentType;

class BlogController extends Controller
{
    private $manager;

    /**
     * @return PostManager
     */
    private function getPostManager()
    {
        return $this->container->get('sano.post_manager');
    }
    
    /**
     * @return CommentManager
     */
    private function getCommentManager()
    {
        return $this->container->get('sano.comment_manager');
    }
    
    /**
     * @Route("/blog", name="_blog")
     * @Template()
     */
    public function indexAction()
    {
        $posts = $this->getPostManager()->findAllPosts();

        return array( 'posts' => $posts);
    }
    
    /**
     * get single Post by id
     *
     * @param  int $id
     * @return Post
     */
    public function getPostAction($id)
    {
        $post = $this->getPostManager()->findPost($id);
        if (!$post) {
            throw new NotFoundHttpException("Objava ne obstaja.");
        }
        return $post;
    }
    
    /**
     * @Route("/blog/post/{id}", name="_post", requirements={"id" = "\d+"})
     * @Template()
     */
    public function postAction($id)
    {
        $post = $this->getPostManager()->findPost($id);
        $comments = $this->getCommentManager()->findAllByPost($id);
        
        return array( 'post' => $post,
                      'comments' => $comments,
                    );
    }
    
    /**
     * @Route("/blog/post/{id}/comment/add", name="_addComment")
     * @Template()
     */
    public function commentAddAction(Request $request, $id)
    {
        $comment = $this->getCommentManager()->createComment();
        $post = $this->getPostManager()->findPost($id);
        $form  = $this->createForm(new CommentType(), $comment);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $comment->setPost($post);
                
                $this->getCommentManager()->saveComment($comment);
                $this->getPostManager()->savePost($post);
                
                $this->get('session')->getFlashBag()->add('success', 'Komentar je bil uspešno shranjen!');

                return $this->redirect($this->generateUrl('_blog'));
            }
        }
        return array(
                     'form'   => $form->createView(),
                     'id'     => $id,
        );  
    }

}
