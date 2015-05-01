<?php

namespace SP\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EvenementEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('NomEvenement');
        $builder->remove('NomOrganisateur');
        
    }
    
    public function getName()
    {
        return 'sp_platformbundle_evenement_edit';
    }

    public function getParent()
    {
        return new EvenementType();
    }
}