<?php

namespace MYT\MakeYourTeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competence
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MYT\MakeYourTeamBundle\Entity\CompetenceRepository")
 */
class Competence{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="MYT\MakeYourTeamBundle\Entity\MyUserCompetence", mappedBy="competence")
     */
    protected $myuser_competences;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Competence
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->myuser_competences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add myuserCompetence
     *
     * @param \MYT\MakeYourTeamBundle\Entity\MyUserCompetence $myuserCompetence
     *
     * @return Competence
     */
    public function addMyuserCompetence(\MYT\MakeYourTeamBundle\Entity\MyUserCompetence $myuserCompetence)
    {
        $this->myuser_competences[] = $myuserCompetence;
        $myuserCompetence->setCompetence($this); //relation bidirectionnelle
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
        $myuserCompetence->setCompetence(null);
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
}
