<?php

namespace MYT\MakeYourTeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="MYT\MakeYourTeamBundle\Entity\MyUserCompetenceRepository")
 */
class MyUserCompetence{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="MYT\MakeYourTeamBundle\Entity\MyUser", inversedBy="myuser_competences")
     */
    private $user;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="MYT\MakeYourTeamBundle\Entity\Competence", inversedBy="myuser_competences")
     */
    private $competence;

    /**
     * @ORM\Column()
     */
    private $niveau;


    /**
     * Set niveau
     *
     * @param string $niveau
     *
     * @return MyUserCompetence
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set user
     *
     * @param \MYT\MakeYourTeamBundle\Entity\MyUser $user
     *
     * @return MyUserCompetence
     */
    public function setUser(\MYT\MakeYourTeamBundle\Entity\MyUser $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MYT\MakeYourTeamBundle\Entity\MyUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set competence
     *
     * @param \MYT\MakeYourTeamBundle\Entity\Competence $competence
     *
     * @return MyUserCompetence
     */
    public function setCompetence(\MYT\MakeYourTeamBundle\Entity\Competence $competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return \MYT\MakeYourTeamBundle\Entity\Competence
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}
