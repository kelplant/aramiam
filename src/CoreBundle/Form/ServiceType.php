<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ServiceType extends AbstractType
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
     * AgenceType constructor.
     * @param string $submitName
     * @param string $typeBtnEN
     */
    public function __construct($submitName, $typeBtnEN)
    {
        $this->submitName = $submitName;
        $this->typeBtnEN = $typeBtnEN;
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
            ->add('name', TextType::class, array(
                'label' => 'Nom du service',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('shortName', TextType::class, array(
                'label' => 'Nom raccourci',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nameInCompany', TextType::class, array(
                'label' => 'Nom dans Company',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nameInOdigo', TextType::class, array(
                'label' => 'Nom dans Odigo',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nameInSalesforce', TextType::class, array(
                'label' => 'Nom dans Salesforce',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nameInZendesk', TextType::class, array(
                'label' => 'Nom dans Zendesk',
                'label_attr' => array(
                    'class' => 'col-sm-2 control-label',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
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
            'data_class' => 'CoreBundle\Entity\Service'
        ));
    }
}
