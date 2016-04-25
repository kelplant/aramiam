<?php

namespace CoreBundle\Form\Admin;

use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Class ServiceType
 * @package CoreBundle\Form\Admin
 */
class ServiceType extends BaseType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class, array(
                'label' => 'id',
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom du service',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('shortName', TextType::class, array(
                'label' => 'Nom raccourci',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('nameInCompany', TextType::class, array(
                'label' => 'Dans Company',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('nameInOdigo', TextType::class, array(
                'label' => 'Dans Odigo',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('nameInSalesforce', TextType::class, array(
                'label' => 'Dans Salesforce',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('nameInZendesk', TextType::class, array(
                'label' => 'Dans Zendesk',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('parentAgence', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeAgences"],
                'multiple' => false,
                'label' => 'Agence Parente',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => true,
            ))
            ->add('activeDirectoryDn', TextType::class, array(
                'label' => 'Dn Active Directory',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Admin\Service'
        ));
    }
}
