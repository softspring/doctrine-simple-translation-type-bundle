<?php

namespace Softspring\DoctrineSimpleTranslationTypeBundle\Form;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmTypeGuesser;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;

class SimpleTranslationTypeGuesser extends DoctrineOrmTypeGuesser implements FormTypeGuesserInterface
{
    public function guessType($class, $property)
    {
        if (!$ret = $this->getMetadata($class)) {
            return new TypeGuess('Symfony\Component\Form\Extension\Core\Type\TextType', [], Guess::LOW_CONFIDENCE);
        }

        /** @var ClassMetadata $metadata */
        list($metadata, $name) = $ret;

        if ($metadata->getTypeOfField($property) == 'simple_translation') {
            return new TypeGuess(SimpleTranslationType::class, [], Guess::VERY_HIGH_CONFIDENCE);
        }

        return null;
    }

    public function guessRequired($class, $property)
    {
        return null;
    }

    public function guessMaxLength($class, $property)
    {
        return null;
    }

    public function guessPattern($class, $property)
    {
        return null;
    }
}