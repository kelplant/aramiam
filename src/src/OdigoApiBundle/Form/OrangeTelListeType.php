<?php
namespace OdigoApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class OrangeTelListeType
 * @package OdigoApiBundle\Form
 */
class OrangeTelListeType extends AbstractType
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
            ->add('numero', TextType::class, array(
                'label' => 'Numéro',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2 orange_tel_liste_numero',
                ),
            ))
            ->add('service', ChoiceType::class, array(
                'choices' => $options["allow_extra_fields"]["listeServices"],
                'label' => 'Service',
                'multiple' => false,
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'form-control font_exo_2 input-md select2-single',
                )
            ))
            ->add('inUse', CheckboxType::class, array(
                'label' => 'Attribué ?',
                'label_attr' => array(
                    'class' => 'col-sm-3 control-label align_right font_exo_2',
                ),
                'attr' => array(
                    'class' => 'font_exo_2',
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
            'data_class' => 'OdigoApiBundle\Entity\OrangeTelListe'
        ));
    }
}
