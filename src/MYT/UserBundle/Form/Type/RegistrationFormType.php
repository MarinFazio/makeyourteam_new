<?php

namespace MYT\UserBundle\Form\Type;

use MYT\MakeYourTeamBundle\Form\MyUserCompetenceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('label' => 'Nom'))
            ->add('prenom', 'text', array('label' => 'Prénom'))
            ->add('age', 'text', array('label' => 'Âge'));
//            ->add('competence', 'collection', array('type' => new MyUserCompetenceType()));
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