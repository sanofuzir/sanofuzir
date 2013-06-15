<?php

namespace sano\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use sano\CoreBundle\Entity\Comment;
use sano\CoreBundle\Models\CommentManager;
use sano\CoreBundle\Form\CommentType;
use sano\CoreBundle\Entity\Post;
use sano\CoreBundle\Models\PostManager;

class CommentController extends Controller
{
    private $manager;

    /**
     * @return CommentManager
     */
    private function getCommentManager()
    {
        return $this->container->get('sano.comment_manager');
    }

    /**
     * @return PostManager
     */
    private function getPostManager()
    {
        return $this->container->get('sano.post_manager');
    }
    
    /**
     * @Route("/comments", name="_admin_comments")
     * @Template()
     */
    public function commentsAction()
    {
        $comments = $this->getCommentManager()->findAllComments();

        return array( 'comments' => $comments);
    }
    
    /**
     * @Route("/comments/delete/{id}", name="_admin_delete_comment", requirements={"id" = "\d+"})
     */
    public function deleteCommentAction($id)
    {

        $this->getCommentManager()->deleteComment($id);
        $this->get('session')->getFlashBag()->add('success', 'Komentar je bil uspešno odstranjen!');
        return $this->redirect($this->generateUrl('_admin_comments'));
    } 
  
    /**
    * @Route("/comment/edit/{id}", name="_admin_edit_comment", requirements={"id" = "\d+"})
    * @Template()
    */
    public function CommentEditAction(Request $request, $id)
    {
        $entity = $this->getCommentManager()->findComment($id);            

        $form  = $this->createForm(new CommentType(), $entity);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                
                $this->getCommentManager()->saveComment($entity);
                $this->get('session')->getFlashBag()->add('success', 'komentar je bil uspešno shranjen!');
                return $this->redirect($this->generateUrl('_admin_comments'));
            }
        }

        return array(
                     'form'   => $form->createView(),
                     'id'     => $id,
        );  
    }
    
    /**
     * @Route("/comment/add/post/{id}", name="_admin_add_comment", requirements={"id" = "\d+"})
     * @Template()
     */
    public function CommentAddAction(Request $request, $id)
    {
        $comment = $this->getCommentManager()->createComment();
        $post = $this->getPostManager()->findPost($id);
        
        $form  = $this->createForm(new CommentForm(), $comment);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $comment->setPost($post);
                
                $this->getCommentManager()->saveComment($comment);
                $this->getPostManager()->savePost($post);

                $this->get('session')->getFlashBag()->add('success', 'komentar je bil uspešno shranjen!');
                return $this->redirect($this->generateUrl('_admin_comments'));
            }
        }
        return array(
                     'form'   => $form->createView(),
                     'id'     => $id,
        );  
    }
    
    /**
     * get single Comment by id
     *
     * @param  int $id
     * @return Comment
     */
    public function getCommentAction($id)
    {
        $comment = $this->getCommentManager()->findComment($id);
        if (!$comment) {
            throw new NotFoundHttpException("Komentar ne obstaja.");
        }
        return $comment;
    }
    
}