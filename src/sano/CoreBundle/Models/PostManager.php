<?php

namespace sano\CoreBundle\Models;

use Doctrine\ORM\EntityManager;
use sano\CoreBundle\Entity\Post;

class PostManager {

	private $class;
	private $em;
	private $repository;

    public function __construct(EntityManager $em, $class )
    {
        $this->em = $em;
        $this->class = $class;
        $this->repository = $em->getRepository($class);
    }
    public function findAllPosts()
    {
        return $this->repository->findAll();
    }

    /**
     * Get single Post by id
     *
     * @param int $id
     * @return Post
     */
    public function findPost($id)
    {
    	return $this->repository->findOneById($id);
    }

    /**
     * Persist Post details
     *
     * @param  Post $entity
     * @return Post
     */
    public function savePost($entity)
    {
    	if ($entity instanceof $this->class) {
    		$this->em->persist($entity);
        	$this->em->flush();
    	}
    	return $this;
    }

    public function deletePost($id)
    {
        $entity = $this->findPost($id);

    	if ($entity instanceof $this->class) {
    		$this->em->remove($entity);
        	$this->em->flush();
    	}
    }
    /**
     * create new Post
     *
     * @return Post
     */
    public function createPost()
    {
        $class = $this->class;
        $entity = new $class();
        return $entity;
    }

}