<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
                ->add('description')
                ->add('body')
                ->add('slug')
                ->add('datePublish',DateType::class,array(
                   'widget'=>'single_text',
                   'format'=>'yyyy-MM-dd',
                   'data' => new \DateTime()))
                ->add('categories',EntityType::class,array
                    (
                        'class' => 'AdminBundle\Entity\Category',
                        'choice_label' =>'libelle',
                        'expanded' => false,
                        'multiple' => true
                    ))
                  ->add('image',FileType::class,array(
                    'label'=>'image jpeg ou png',
                    'data_class'=> null
                    ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_post';
    }


}
