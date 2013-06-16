<?php

namespace sano\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
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
