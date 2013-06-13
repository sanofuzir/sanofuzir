<?php

namespace sano\CoreBundle\Models;

use Doctrine\ORM\EntityManager;
use sano\CoreBundle\Entity\News;

class NewsManager {

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
     * Get all news
     * 
     * @return News
     */
    public function findAllNews()
    {
        return $this->repository->findAll();
    }
    /**
     * Get last 3 news order by creation date
     * 
     * @return News
     */
    public function findAllWithLimit($limit)
    {
        return $this->repository->findAllWithLimit($limit);
    }

    /**
     * Get single news by id
     *
     * @param int $id
     * @return News
     */
    public function findNews($id)
    {
    	return $this->repository->findOneById($id);
    }

    /**
     * Persist news details
     *
     * @param  News $entity
     * @return News
     */
    public function saveNews($entity)
    {
    	if ($entity instanceof $this->class) {
    		$this->em->persist($entity);
        	$this->em->flush();
    	}
    	return $this;
    }

    public function deleteNews($id)
    {
        $entity = $this->findNews($id);

    	if ($entity instanceof $this->class) {
    		$this->em->remove($entity);
        	$this->em->flush();
    	}
    }
    /**
     * create new News
     *
     * @return News
     */
    public function createNews()
    {
        $class = $this->class;
        $entity = new $class();
        return $entity;
    }

}