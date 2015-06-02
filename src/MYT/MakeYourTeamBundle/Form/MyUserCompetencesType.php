<?php

namespace MYT\MakeYourTeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MyUserCompetencesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add($builder->create('myuser_competences', 'collection', array(
            'type'          => new MyUserCompetenceType(),
            'allow_add'     => true,
            'allow_delete'  => true,
        )));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
//            'data_class' => 'MYT\MakeYourTeamBundle\Entity\MyUserCompetences',
        ));
    }

    public function getName()
    {
        return 'myt_user_competences';
    }

}