<?php
namespace SalesforceApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class SalesforceTerritoryType
 * @package SalesforceApiBundle\Form
 */
class SalesforceTerritoryType extends AbstractType
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
            ->add('territoryId', TextType::class, array(
                'label' => 'Territoire Id',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('territoryName', TextType::class, array(
                'label' => 'Nom du Territoire',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('parentTerritoryId', TextType::class, array(
                'label' => 'Territoire Parent Id',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
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
            'data_class' => 'SalesforceApiBundle\Entity\SalesforceTerritory'
        ));
    }
}
