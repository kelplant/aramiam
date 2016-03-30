<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use CoreBundle\Services\Manager\FonctionManager as FonctionManager;

class CandidatType extends AbstractType
{
    /**
     * @var string
     */
    private $submitName;

    /**
     * @var string
     */
    private $typeBtnEN;


    /**
     * CandidatType constructor.
     */
    public function __construct()
    {
        $path = substr(Request::createFromGlobals()->getPathInfo(), 17, 4);

        if ($path == 'add')
        {
            $this->submitName = 'Envoyer';
            $this->typeBtnEN = 'Envoyer et Nouveau';
        }
        if ($path == 'edit')
        {
            $this->submitName = 'Mettre & Jour';
            $this->typeBtnEN = 'MàJ et Rester';
        }
    }

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
                    'M' => 'Monsieur',
                    'Mme' => 'Madame',
                    'Mlle' =>'Mademoiselle',
                ),
                'label' => 'Civilité',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom du candidat',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Prénom du candidat',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('startDate', TextType::class, array(
                'label' => 'Date de démarrage',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control date',
                ),
            ))
            ->add('responsable', TextType::class, array(
                'label' => 'Responsable du candidat',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('matriculeRH', TextType::class, array(
                'label' => 'Matricule RH du candidat',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('agence', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeAgences"],
                'label' => 'Agence',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'onChange'=> 'submit()',
                )
            ))
            ->add('service', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeServices"],
                'label' => 'Service',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'onChange'=> 'submit()',
                )
            ))
            ->add('fonction', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeFonctions"],
                'label' => 'Fonction',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                    'onChange'=> 'submit()',
                )
            ))
            ->add('Envoyer', SubmitType::class, array(
                'label' => $this->submitName,
                'attr' => array(
                    'class' => 'btn btn-success',
                ),
            ))
            ->add('EnvoyerNouveau', SubmitType::class, array(
                'label' => $this->typeBtnEN,
                'attr' => array(
                    'class' => 'btn btn-info',
                ),
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
