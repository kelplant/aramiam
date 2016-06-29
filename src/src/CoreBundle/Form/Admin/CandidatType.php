<?php
namespace CoreBundle\Form\Admin;

use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class CandidatType
 * @package CoreBundle\Form\Admin
 */
class CandidatType extends BaseType
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
                    'placeholder' => 'Saisir une civilité',
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'required' => false,
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir un nom',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => true,
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Prénom',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir un prénom',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => true,
            ))
            ->add('startDate', TextType::class, array(
                'label' => 'Date d\'arrivée',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2 datepicker',
                ),
                'attr' => array(
                    'placeholder' => ' Choisir une Date',
                    'class' => 'form-control date font_exo_2 datepicker',
                ),
                'required' => true,
            ))
            ->add('responsable', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeUtilisateurs"],
                'label' => 'Responsable',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Civilité',
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'required' => false,
            ))
            ->add('matriculeRH', NumberType::class, array(
                'label' => 'Matricule RH',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir un matricule',
                    'class' => 'form-control font_exo_2 checkNumber',
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
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'required' => false,
            ))
            ->add('agence', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeAgences"],
                'label' => 'Agence',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'group_by' => function($val, $key) {
                    if ($val == 31) {
                        return $key;
                    } else {
                        return 'Agence';
                    }
                },
                'required' => false,
            ))
            ->add('service', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeServices"],
                'label' => 'Service',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'required' => false,
            ))
            ->add('fonction', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeFonctions"],
                'label' => 'Fonction',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'required' => false,
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
                    'class' => 'form-control font_exo_2 statusPoste input-md select2-single',
                ),
                'required' => false,
            ))
            ->add('predecesseur', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeUtilisateurs"],
                'label' => 'Prédécesseur',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2 input-md select2-single',
                ),
                'required' => false,
            ))
            ->add('commentaire', TextareaType::class, array(
                'label' => 'Commentaire',
                'label_attr' => array(
                    'class' => 'col-sm-4 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'placeholder' => 'Saisir un commentaire',
                    'class' => 'form-control font_exo_2',
                ),
                'required' => false,
            ))
            ->add('createdDate', HiddenType::class, array(
                'label' => 'createdDate',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Admin\Candidat'
        ));
    }
}
