<?php

namespace sano\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="sano\CoreBundle\Entity\NewsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class News
{

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
    * @var string
    *
    * @ORM\Column(length=255)
    */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
    * @var string
    *
    * @ORM\Column(type="text")
    * @Assert\NotNull(
    *     message = "To polje ne sme biti prazno!"
    * )
    */
    protected $text;
    
    public function __construct() {
        $this->created = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Ad
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * Set text
     *
     * @param string $text
     * @return Ad
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

}