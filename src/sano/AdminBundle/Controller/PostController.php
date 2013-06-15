<?php

namespace sano\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use sano\CoreBundle\Entity\Post;
use sano\CoreBundle\Models\PostManager;
use sano\CoreBundle\Form\PostType;

class PostController extends Controller
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
     * @Route("/posts", name="_admin_posts")
     * @Template()
     */
    public function postsAction()
    {
        $posts = $this->getPostManager()->findAllPosts();

        return array( 'posts' => $posts);
    }
    
    /**
     * @Route("/post/delete/{id}", name="_admin_delete_post", requirements={"id" = "\d+"})
     */
    public function deletePostAction($id)
    {

        $this->getPostManager()->deletePost($id);
        $this->get('session')->getFlashBag()->add('success', 'Objava je bil uspešno odstranjena!');
        return $this->redirect($this->generateUrl('_admin_posts'));
    } 
    
    /**
     * @Route("/post/add", name="_admin_add_post")
     * @Route("/post/edit/{id}", name="_admin_edit_post", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editPostAction(Request $request, $id = null)
    {
        if (is_null($id)) {
            $entity = $this->getPostManager()->createPost();
        } else {
            $entity = $this->getPostAction($id);
        }

        $form  = $this->createForm(new PostType(), $entity);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $this->getPostManager()->savePost($entity);
                $this->get('session')->getFlashBag()->add('success', 'Objava je bila uspešno shranjena!');
                return $this->redirect($this->generateUrl('_admin_posts'));
            }
        }

        return array(
            'form'   => $form->createView(),
            'post' => $entity,
        );
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
}