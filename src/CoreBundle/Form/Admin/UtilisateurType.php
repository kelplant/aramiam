<?php

namespace CoreBundle\Form\Admin;

use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateurType extends BaseType
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
            ->add('idCandidat', HiddenType::class, array(
                'label' => 'idCandidat',
            ))
            ->add('civilite', ChoiceType::class, array(
                'choices' => array(
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame',
                    'Mademoiselle' =>'Mademoiselle',
                ),
                'label' => 'Civilité',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                )
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Prénom',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('viewName', TextType::class, array(
                'label' => 'Affiché',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('mainPassword', PasswordType::class, array(
                'label' => 'Password',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('startDate', TextType::class, array(
                'label' => 'Date d\'arrivée',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control date font_exo_2 datepicker',
                ),
            ))
            ->add('responsable', ChoiceType::class, array(
                'label' => 'Responsable',
                'choices' => $options["allow_extra_fields"]["listeUtilisateurs"],
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('matriculeRH', TextType::class, array(
                'label' => 'Matricule RH',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('entiteHolding', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeEntites"],
                'label' => 'Entité',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                )
            ))
            ->add('agence', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeAgences"],
                'label' => 'Agence',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                )
            ))
            ->add('service', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeServices"],
                'label' => 'Service',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                )
            ))
            ->add('fonction', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeFonctions"],
                'label' => 'Fonction',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                )
            ))
            ->add('statusPoste', ChoiceType::class, array(
                'choices' => array(
                    'Remplacement' => 'Remplacement',
                    'Création' => 'Création',
                ),
                'label' => 'Status Poste',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                )
            ))
            ->add('predecesseur', ChoiceType::class, array(
                'label' => 'Prédécesseur',
                'choices' => $options["allow_extra_fields"]["listeUtilisateurs"],
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('commentaire', TextareaType::class, array(
                'label' => 'Commentaire',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('isCreateInGmail', HiddenType::class, array(
                'label' => 'isCreateInGmail',
                'required' => false,
            ))
            ->add('isCreateInOdigo', HiddenType::class, array(
                'label' => 'isCreateInOdigo',
                'required' => false,
            ))
            ->add('isCreateInRobusto', HiddenType::class, array(
                'label' => 'isCreateInRobusto',
                'required' => false,
            ))
            ->add('isCreateInSalesforce', HiddenType::class, array(
                'label' => 'isCreateInSalesforce',
                'required' => false,
            ))
            ->add('isCreateInWindows', HiddenType::class, array(
                'label' => 'isCreateInSalesforce',
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
            'data_class' => 'CoreBundle\Entity\Admin\Utilisateur'
        ));
    }
}
