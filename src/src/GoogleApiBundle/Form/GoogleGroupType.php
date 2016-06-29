<?php
namespace GoogleApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class GoogleGroupType
 * @package GoogleApiBundle\Form
 */
class GoogleGroupType extends AbstractType
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
                'label' => 'Groupe Google',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                    'readonly' => true,
                ),
            ))
            ->add('email', TextType::class, array(
                'label' => 'Email du groupe',
                'label_attr' => array(
                    'class' => 'col-sm-5 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2',
                    'readonly' => true,
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
            'data_class' => 'GoogleApiBundle\Entity\GoogleGroup'
        ));
    }
}
