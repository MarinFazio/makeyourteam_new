<?php

namespace MYT\MakeYourTeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MyUserCompetenceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('competence', 'entity', array(
                'class'     => 'MakeYourTeamBundle:Competence',
                'property'  => 'nom',
            ))
            ->add('niveau', 'choice', array(
                'choices' => array('junior' => 'Junior', 'avance' => 'Avancé', 'senior' => 'Senior')
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MYT\MakeYourTeamBundle\Entity\MyUserCompetence',
        ));
    }

    public function getName()
    {
        return 'myt_user_competence';
    }

}