<?php

namespace MYT\MakeYourTeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnonceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text')
            ->add('contenu', 'ckeditor', array(
                'transformers'                 => array('html_purifier'),
//                'toolbar_groups'               => array(
//                    'document' => array('Source')
//                ),
                'startup_outline_blocks'       => false,
                'width'                        => '75%',
                'height'                       => '250',
                'language'                     => 'fr',
            ))
            ->add('published', 'checkbox', array('required' => false))
            ->add('image' , new ImageType())
            ->add('categorie', 'entity', array(
                'class'     => 'MakeYourTeamBundle:Categorie',
                'property'  => 'nom',
                'multiple'  => false,
            ))
            ->add('enregistrer', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MYT\MakeYourTeamBundle\Entity\Annonce'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'myt_makeyourteambundle_annonce';
    }
}
