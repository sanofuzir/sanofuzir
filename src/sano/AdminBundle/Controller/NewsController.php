<?php

namespace sano\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use sano\CoreBundle\Entity\News;
use sano\CoreBundle\Models\NewsManager;
use sano\CoreBundle\Form\NewsType;

class NewsController extends Controller
{
    private $manager;

    /**
     * @return NewsManager
     */
    private function getNewsManager()
    {
        return $this->container->get('sano.news_manager');
    }

    /**
     * @Route("/news", name="_admin_news")
     * @Template()
     */
    public function newsAction()
    {
        $news = $this->getNewsManager()->findAllNews();

        return array( 'news' => $news);
    }
    
    /**
     * @Route("/news/delete/{id}", name="_admin_delete_news", requirements={"id" = "\d+"})
     */
    public function deleteNewsAction($id)
    {

        $this->getNewsManager()->deleteNews($id);
        $this->get('session')->getFlashBag()->add('success', 'Novica je bil uspešn odstranjena!');
        return $this->redirect($this->generateUrl('_admin_news'));
    } 
    
    /**
     * @Route("/news/add", name="_admin_add_news")
     * @Route("/news/edit/{id}", name="_admin_edit_news", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editNewsAction(Request $request, $id = null)
    {
        if (is_null($id)) {
            $entity = $this->getNewsManager()->createNews();
        } else {
            $entity = $this->getNewsAction($id);
        }

        $form  = $this->createForm(new NewsType(), $entity);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $this->getNewsManager()->saveNews($entity);
                $this->get('session')->getFlashBag()->add('success', 'Novica je bila uspešno shranjena!');
                return $this->redirect($this->generateUrl('_admin_news'));
            }
        }

        return array(
            'form'   => $form->createView(),
            'news' => $entity,
        );
    }
    
    /**
     * get single News by id
     *
     * @param  int $id
     * @return News
     */
    public function getNewsAction($id)
    {
        $news = $this->getNewsManager()->findNews($id);
        if (!$news) {
            throw new NotFoundHttpException("Novica ne obstaja.");
        }
        return $news;
    }
}