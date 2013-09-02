<?php

namespace sano\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Questionnaire
 *
 * @ORM\Table(name="questionnaire")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="sano\CoreBundle\Entity\QuestionnaireRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Questionnaire 
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
     * @ORM\Column
     * @Assert\NotBlank(
     *     message = "To polje ne sme biti prazno!"
     * )
     * 
     */
    protected $name;
    
    /**
     * @var string
     *
     * @ORM\Column
     * @Assert\NotBlank(
     *     message = "To polje ne sme biti prazno!"
     * )
     */
    protected $surname;
    
    /**
     * @var string
     * @ORM\Column(length=255)
     * @Assert\Email(
     *     message = "Email ni veljaven!",
     *     checkMX = true
     * )
     * @Assert\NotBlank(
     *     message = "To polje ne sme biti prazno!"
     * )
     */
    protected $email;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\Date(
     *      message = "Nepravilna oblika datuma! (dd.mm.YYYY)"
     * )
     * @Assert\NotBlank(
     *      message = "To polje ne sme biti prazno!"
     * )
     */
    protected $date_of_birth;
    
    /**
    * @var string
    *
    * @ORM\Column(length=255)
    * @Assert\NotBlank(
    *   message = "To polje ne sme biti prazno!"
    * )  
    */
    protected $browser;
    

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
     * @return Questionnaire
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
     * Set surname
     *
     * @param string $surname
     * @return Questionnaire
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    
        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Questionnaire
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set date_of_birth
     *
     * @param \DateTime $dateOfBirth
     * @return Questionnaire
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->date_of_birth = $dateOfBirth;
    
        return $this;
    }

    /**
     * Get date_of_birth
     *
     * @return \DateTime 
     */
    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    /**
     * Set browser
     *
     * @param string $browser
     * @return Questionnaire
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    
        return $this;
    }

    /**
     * Get browser
     *
     * @return string 
     */
    public function getBrowser()
    {
        return $this->browser;
    }
}