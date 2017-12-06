<?php

namespace SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('required_last_name', 'text',
                array(
                    'label' => 'Nume*',
                    'label_attr' => array('class' => 'col-md-2'),
                    'attr' => array('class'=>'form-control col-md-8 col-xs-12')
                )
            )
            ->add('required_first_name', 'text',
                array(
                    'label' => 'Prenume*',
                    'label_attr' => array('class' => 'col-md-2'),
                    'attr' => array('class'=>'form-control col-md-8 col-xs-12')
                )
            )
            ->add('required_email', 'email',
                array(
                    'label' => 'Email*',
                    'label_attr' => array('class' => 'col-md-2'),
                    'attr' => array('class'=>'form-control col-md-8 col-xs-12')
                )
            )
            ->add('message', 'textarea',
                array(
                    'label' => 'Mesaj funny',
                    'label_attr' => array('class' => 'col-md-2'),
                    'max_length' => '300',
                    'attr' => array(
                        'class'=>'col-md-8 no-resize col-xs-12',
                        'rows' => '6'
                        ),
                    'required' => false
                )
            )
            ->add('date', 'date',
                array(
                    'label_attr' => array('class' => 'col-md-2'),
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    'label' => 'Data nasterii*',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(1950,1997),
                    'attr' => array('class'=>'col-md-2 nopadding col-xs-12'),
                    'required' => false
                )
            )
            ->add('image', 'file',
                array(
                    'label' => 'Imagine haioasa',
                    'label_attr' => array('class' => 'col-md-2'),
                    'attr' => array('class'=>'col-md-8 nopadding  col-xs-12'),
                    'required' => false
                )
            )
            ->add('required_sex', 'choice',
                array(
                    'choices' => array(
                        '' => 'Alege',
                        'm' => 'Masculin',
                        'f' => 'Feminin'
                    ),
                    'label' => 'Gen*',
                    'label_attr' => array('class' => 'col-md-2'),
                    'attr' => array('class'=>'col-md-2')
                )
            )
            ->add('anonymous', 'checkbox',
                array(
                    'label' => 'Posteaza ca anonim',
                    'label_attr' => array('class' => 'col-md-3 text-right'),
                    'attr' => array('class'=>'col-md-1'),
                    'required' => false
                )
            )
            ->add('send', 'button',
                array(
                    'label' => 'Inscrie-te',
                    'attr' => array('class'=>'btn btn-theme btn-lg btn-block col-md-offset-2 col-md-8 col-xs-12')
                )
            )
            ->getForm();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'share';
    }
}
