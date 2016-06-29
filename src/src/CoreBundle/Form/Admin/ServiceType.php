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
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir un nom de Service',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => true,
            ))
            ->add('shortName', TextType::class, array(
                'label' => 'Nom raccourci',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir un nom court de Service',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => true,
            ))
            ->add('nameInCompany', TextType::class, array(
                'label' => 'Dans Company',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir la correspondance Company',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('nameInOdigo', TextType::class, array(
                'label' => 'Dans Odigo',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir la correspondance Odigo',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('nameInSalesforce', TextType::class, array(
                'label' => 'Dans Salesforce',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir la correspondance Salesforce',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('nameInZendesk', TextType::class, array(
                'label' => 'Dans Zendesk',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir la correspondance Zendesk',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('parentAgence', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeAgences"],
                'multiple' => false,
                'label' => 'Agence Parente',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'required' => true,
            ))
            ->add('parentService', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeServices"],
                'preferred_choices' => 'Choisir un Service',
                'multiple' => false,
                'label' => 'Service Parent',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'required' => true,
            ))
            ->add('nameInActiveDirectory', TextType::class, array(
                'label' => 'Dans l\'AD Windows',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir la correspondance Windows',
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
