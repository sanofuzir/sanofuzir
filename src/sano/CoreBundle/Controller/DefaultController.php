<?php

namespace sano\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sano\CoreBundle\Entity\Questionnaire;
use Sano\CoreBundle\Models\QuestionnaireManager;
use Sano\CoreBundle\Form\QuestionnaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class DefaultController extends Controller
{
    private $manager;

    /**
     * @return QuestionnaireManager
     */
    private function getQuestionnaireManager()
    {
        return $this->container->get('sano.questionnaire_manager');
    }
    
    /**
     * @Route("/core")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/questionnaire", name="_questionnaire")
     * @Template()
     */
    public function questionnaireAction()
    {
        $results = $this->getQuestionnaireManager()->getQuestionnaireResults();
        $num_of_votes = $this->getQuestionnaireManager()->getNumOfVotes();
        
        return array('results' => $results,
                     'num_of_votes' => $num_of_votes,
                    );
        
    }
    
    /**
     * @Route("/questionnaire/add", name="_add_questionnaire")
     * @Template()
     */
    public function editQuestionnaireAction(Request $request, $id = null)
    {

        $entity = $this->getQuestionnaireManager()->createQuestionnaire();

        //$form  = $this->createForm(new QuestionnaireType(), $entity); 
        
        $form = $this->createFormBuilder($entity)
            ->add('name',null, array(
                'attr'  => array('class' => 'span7'),
                'label' => 'Ime'
            ))             
            ->add('surname', null, array(
                'attr'  => array('class' => 'span7'),
                'label' => 'Priimek'
            ))             
            ->add('email', null, array(
                'attr'  => array('class' => 'span7'),
                'label' => 'email'
            ))
            ->add('date_of_birth', 'date', array(
                'attr'  => array('class' => 'span2'),
                'label' => 'Datum rojstva',
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy'
            ))
            ->add('browser', 'choice', array(
                'choices'   => array(
                'empty_value' => false,
                'Safari'   => 'Safari',
                'Mozilla' => 'Mozilla',
                'Opera'   => 'Opera',
                'Internet explorer'   => 'Internet explorer',
                'Chrome'   => 'Chrome',
                )
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $this->getQuestionnaireManager()->saveQuestionnaire($entity);
                $this->get('session')->getFlashBag()->add('success', 'Vaš glas je bil uspešno shranjen!');
                
                $num_of_votes = $this->getQuestionnaireManager()->getNumOfVotes();
                $results = $this->getQuestionnaireManager()->getQuestionnaireResults();
                
                $message = \Swift_Message::newInstance()
                    ->setSubject('Rezultati ankete')
                    ->setFrom('sano.fuzir@gmail.com')
                    ->setTo('sano.fuzir@gmail.com')
                    ->setBody(
                $this->renderView(
                'CoreBundle:Default:email.html.twig',
                array('results' => $results,
                      'num_of_votes' => $num_of_votes,
                     )
            )
        )
        ;
                $this->get('mailer')->send($message);
                 
                return $this->redirect($this->generateUrl('_questionnaire'));
            }
        }
        return array(
            'form'   => $form->createView(),
            'questionnaire' => $entity,
        );
    }
}
