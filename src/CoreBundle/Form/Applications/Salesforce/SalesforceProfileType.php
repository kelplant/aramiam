<?php
namespace CoreBundle\Form\Applications\Salesforce;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SalesforceProfileType extends AbstractType
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
            ->add('profileId', TextType::class, array(
                'label' => 'Profile Id',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('profileName', TextType::class, array(
                'label' => 'Nom du Profile',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('userLicenseId', TextType::class, array(
                'label' => 'License Id',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                ),
            ))
            ->add('userType', TextType::class, array(
                'label' => 'Type d\'Utilisateur',
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
            'data_class' => 'CoreBundle\Entity\Applications\Salesforce\SalesforceProfile'
        ));
    }
}
