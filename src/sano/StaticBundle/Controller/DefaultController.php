<?php

namespace sano\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use sano\CoreBundle\Entity\News;
use sano\CoreBundle\Models\NewsManager;

class DefaultController extends Controller
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
     * @Route("/", name="_home")
     * @Template()
     */
    public function indexAction()
    {
        $news = $this->getNewsManager()->findAllWithLimit(2);

        return array( 'news' => $news);
    }
    
    /**
     * @Route("/about", name="_about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
    
    /**
     * @Route("/contact", name="_contact")
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }
    /**
     * @Route("/projects", name="_projects")
     * @Template()
     */
    public function projectsAction()
    {
        return array();
    }
}
