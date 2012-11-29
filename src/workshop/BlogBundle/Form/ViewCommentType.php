<?php

namespace workshop\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ViewCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text')
            ->add('post','hidden',array('property_path' => 'post.id'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'workshop\BlogBundle\Entity\Comment'
        ));
    }

    public function getName()
    {
        return 'workshop_blogbundle_commenttype';
    }
}
