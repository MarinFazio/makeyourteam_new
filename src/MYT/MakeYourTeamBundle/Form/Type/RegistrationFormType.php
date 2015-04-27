<?php

namespace MYT\MakeYourTeamBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', 'text', array('label' => 'Nom'));
        $builder->add('prenom', 'text', array('label' => 'Prénom'));
        $builder->add('age', 'text', array('label' => 'Âge'));
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