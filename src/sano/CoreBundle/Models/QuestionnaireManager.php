<?php

namespace sano\CoreBundle\Models;

use Doctrine\ORM\EntityManager;
use sano\CoreBundle\Entity\Questionnaire;

class QuestionnaireManager {

	private $class;
	private $em;
	private $repository;

    public function __construct(EntityManager $em, $class )
    {
        $this->em = $em;
        $this->class = $class;
        $this->repository = $em->getRepository($class);
    }
    /**
     * Get questionnaire results
     * 
     * @return results 
     */
    public function getQuestionnaireResults()
    {
        return $this->repository->getQuestionnaireResults();
    }
    /**
     * Get number of all votes
     * 
     * @return int
     */
    public function getNumOfVotes()
    {
        return $this->repository->getNumOfVotes();
    }
    /**
     * Get all Questionnaires
     * 
     * @return Questionnaire
     */
    public function findAllQuestionnaires()
    {
        return $this->repository->findAll();
    }
    /**
     * Get single Questionnaire by id
     *
     * @param int $id
     * @return Questionnaire
     */
    public function findQuestionnaire($id)
    {
    	return $this->repository->findOneById($id);
    }

    /**
     * Persist Questionnaire details
     *
     * @param  Questionnaire $entity
     * @return Questionnaire
     */
    public function saveQuestionnaire($entity)
    {
    	if ($entity instanceof $this->class) {
    		$this->em->persist($entity);
        	$this->em->flush();
    	}
    	return $this;
    }

    public function deleteQuestionnaire($id)
    {
        $entity = $this->findQuestionnaire($id);

    	if ($entity instanceof $this->class) {
    		$this->em->remove($entity);
        	$this->em->flush();
    	}
    }
    /**
     * create new Questionnaire
     *
     * @return Questionnaire
     */
    public function createQuestionnaire()
    {
        $class = $this->class;
        $entity = new $class();
        return $entity;
    }

}