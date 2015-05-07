<?php

namespace MYT\MakeYourTeamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MYT\MakeYourTeamBundle\Entity\Competence;

class LoadCompetenceData implements FixtureInterface{

    public function load(ObjectManager $manager)
    {
        //Une compétence
        $competence = new Competence();
        $competence->setNom("HTML5");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("CSS3");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("PHP5");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("Word");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("Excel");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("PowerPoint");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("MySql");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("Java");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("JavaScript");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("Android");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("XML");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("IOS");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("Objective C");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("Symfony 2");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("Zend FrameWork");

        $manager->persist($competence);
        $manager->flush();

        //Une compétence
        $competence = new Competence();
        $competence->setNom("Zend FrameWork 2");

        $manager->persist($competence);
        $manager->flush();


    }

}