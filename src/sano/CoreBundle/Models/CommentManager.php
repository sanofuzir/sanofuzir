<?php

namespace sano\CoreBundle\Models;

use Doctrine\ORM\EntityManager;
use sano\CoreBundle\Entity\Comment;

class CommentManager {

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
     * Get all Comment
     * 
     * @return Comment
     */
    public function findAllComments()
    {
        return $this->repository->findAll();
    }
    /**
     * Get last 3 news order by creation date
     * 
     * @return Comment
     */
    public function findAllWithLimit($limit)
    {
        return $this->repository->findAllWithLimit($limit);
    }

    /**
     * Get single Comment by id
     *
     * @param int $id
     * @return Comment
     */
    public function findComment($id)
    {
    	return $this->repository->findOneById($id);
    }

    /**
     * Persist Comment details
     *
     * @param  Comment $entity
     * @return Comment
     */
    public function saveComment($entity)
    {
    	if ($entity instanceof $this->class) {
    		$this->em->persist($entity);
        	$this->em->flush();
    	}
    	return $this;
    }

    public function deleteComment($id)
    {
        $entity = $this->findComment($id);

    	if ($entity instanceof $this->class) {
    		$this->em->remove($entity);
        	$this->em->flush();
    	}
    }
    /**
     * create new Comment
     *
     * @return Comment
     */
    public function createComment()
    {
        $class = $this->class;
        $entity = new $class();
        return $entity;
    }

}