<?php

namespace BviEmailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder,array $options) {

    	$builder->add('subject', 'text')
                ->add('content', 'textarea')
                ->add('status', 'choice', array('choices' => array('Active' => 'Active', 'Inactive' => 'Inactive'), 'multiple' => false, 'expanded' => true,
                'empty_value' => false));
    }

    public function getName() {
        return 'email_template';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BviEmailBundle\Entity\Email'
        ));
    }

}

