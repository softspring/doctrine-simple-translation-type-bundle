<?php

namespace Softspring\DoctrineSimpleTranslationTypeBundle\Form;

use Softspring\DoctrineSimpleTranslationTypeBundle\Model\SimpleTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SimpleTranslationType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SimpleTranslation::class,
            'languages' => ['en', 'es'],
            'by_reference' => false, // forces doctrine to detect changes
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['languages'] as $language) {
            $builder->add($language, TextType::class, [
                'required' => false,
                'property_path' => "translations[$language]",
            ]);
        }
    }
}
