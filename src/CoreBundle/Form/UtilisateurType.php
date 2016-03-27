<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('viewName')
            ->add('email')
            ->add('odigoPhoneNumber')
            ->add('redirectPhoneNumber')
            ->add('odigoExtension')
            ->add('startDate', 'datetime')
            ->add('robustoProfil')
            ->add('isCreateInOdigo')
            ->add('isCreateInGmail')
            ->add('isActive')
            ->add('isDelete')
            ->add('agence')
            ->add('service')
            ->add('fonction')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Utilisateur'
        ));
    }
}
