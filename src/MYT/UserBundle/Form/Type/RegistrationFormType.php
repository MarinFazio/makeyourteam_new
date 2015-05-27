<?php

namespace MYT\UserBundle\Form\Type;

use MYT\MakeYourTeamBundle\Form\MyUserCompetenceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('label' => 'Nom'))
            ->add('prenom', 'text', array('label' => 'Prénom'))
            ->add('age', 'text', array('label' => 'Âge'))//;
            ->add($builder->create('myuser_competences', 'collection'
                                                            , array('type'        => new MyUserCompetenceType(),
                                                            'allow_add'           => true,
                                                            'allow_delete'        => true,
                                                            )));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MYT\MakeYourTeamBundle\Entity\MyUser',
        ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'myt_user_registration';
    }
}