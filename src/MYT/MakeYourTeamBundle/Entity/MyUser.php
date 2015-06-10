<?php

namespace MYT\MakeYourTeamBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Acl\Domain\DoctrineAclCache;

/**
 * Class MyUser
 * @ORM\Entity
 * @ORM\Table(name="myt_user")
 * @ORM\Entity(repositoryClass="MYT\UserBundle\Entity\UserRepository")
 */
class MyUser extends BaseUser{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", length=255)
     */
    protected $nom;

    /**
     * @var string
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    protected $prenom;

    /**
     * @var string
     * @ORM\Column(name="age", type="integer")
     */
    protected $age;

    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="MYT\MakeYourTeamBundle\Entity\MyUserCompetence", mappedBy="user",cascade={"persist"})
     */
    protected $myuser_competences;

    public function __construct()
    {
        parent::__construct();
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    /**
     * Add myuserCompetence
     *
     * @param \MYT\MakeYourTeamBundle\Entity\MyUserCompetence $myuserCompetence
     *
     * @return MyUser
     */
    public function addMyuserCompetence(\MYT\MakeYourTeamBundle\Entity\MyUserCompetence $myuserCompetence)
    {
        $this->myuser_competences[] = $myuserCompetence;
        $myuserCompetence->setUser($this);//relation bidirectionnelle
        return $this;
    }

    /**
     * Remove myuserCompetence
     *
     * @param \MYT\MakeYourTeamBundle\Entity\MyUserCompetence $myuserCompetence
     */
    public function removeMyuserCompetence(\MYT\MakeYourTeamBundle\Entity\MyUserCompetence $myuserCompetence)
    {
        $this->myuser_competences->removeElement($myuserCompetence);
        //relation bidirectionnelle
        $myuserCompetence->setUser(null);
    }

    /**
     * Get myuserCompetences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyuserCompetences()
    {
        return $this->myuser_competences;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MyUser
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
