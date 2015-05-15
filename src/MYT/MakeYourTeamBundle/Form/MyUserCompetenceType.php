<?php

namespace MYT\MakeYourTeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MyUserCompetenceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('competence', 'entity', array(
                'class'     => 'MakeYourTeamBundle:Competence',
                'property'  => 'nom',
            ))
            ->add('gender', 'choice', array(
                'choices' => array('junior' => 'Junior', 'avance' => 'Avancé', 'senior' => 'Senior')
            ));
    }

    public function getName()
    {
        return 'myt_user_competence';
    }

}