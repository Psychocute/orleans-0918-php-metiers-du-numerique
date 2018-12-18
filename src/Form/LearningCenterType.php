<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\LearningCenter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LearningCenterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('pictureFile', VichImageType::class, [
                'required' => true,
                'download_link' => false,
                'allow_delete' => false,
                'label' => ' ',
                'attr' => array('aria-describedby' => 'fileHelp', 'class' => 'form-control-file')
            ])
            ->add('mail', TextType::class, [
                'label' => 'Adresse mail de votre entreprise',
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien du site de votre entreprise',

            ])
            ->add('jobs', EntityType::class, [
                'class'=>Job::class,
                'label' => 'Sélectionnez les fiches métiers auquelles vous voulez être relatées: ',
                'choice_label'=>'name',
                'by_reference' => false,
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LearningCenter::class,
        ]);
    }
}
