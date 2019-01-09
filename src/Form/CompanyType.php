<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Job;
use App\Repository\JobRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => array('type' => 'text', 'class' => 'color-input'),
                'label' => "Nom de votre entreprise",
            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'download_link' => false,
                'allow_delete' => false,
                'label' => ' ',
                'attr' => array('aria-describedby' => 'fileHelp', 'class' => 'form-control-file')
            ])
            ->add('mail', TextType::class, [
                'attr' => array('type' => 'text', 'class' => 'color-input'),
                'label' => 'Adresse mail de votre entreprise',
            ])
            ->add('link', TextType::class, [
                'attr' => array('type' => 'text', 'class' => 'color-input'),
                'label' => 'Lien du site de votre entreprise',

            ])
            ->add('jobs', ChoiceType::class, [
                'choices' => [
                        'php' => 'back_1',
                        'java' => 'back_2',
                        'js' => 'front_1',
                ],
                'group_by' => function($choiceValue, $key, $value) {
                    $cat = explode('_', $choiceValue);
                    return $cat[0];
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
