<?php

namespace CoreBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('viewName')
            ->add('idCandidat')
            ->add('email')
            ->add('isCreateInOdigo')
            ->add('isCreateInGmail')
            ->add('isCreateInSalesforce')
            ->add('isCreateInRobusto')
            ->add('isActive')
            ->add('isDelete')
            ->add('name')
            ->add('surname')
            ->add('civilite')
            ->add('startDate', 'date')
            ->add('entiteHolding')
            ->add('agence')
            ->add('service')
            ->add('fonction')
            ->add('statusPoste')
            ->add('predecesseur')
            ->add('responsable')
            ->add('matriculeRH')
            ->add('commentaire')
            ->add('isArchived')
            ->add('isConvertedUser')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Admin\Utilisateur'
        ));
    }
}
