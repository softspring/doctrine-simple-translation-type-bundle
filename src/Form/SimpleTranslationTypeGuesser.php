<?php

namespace Softspring\DoctrineSimpleTranslationTypeBundle\Form;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmTypeGuesser;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Form\Guess\ValueGuess;

class SimpleTranslationTypeGuesser extends DoctrineOrmTypeGuesser implements FormTypeGuesserInterface
{
    public function guessType($class, $property): ?TypeGuess
    {
        if (!$ret = $this->getMetadata($class)) {
            return new TypeGuess('Symfony\Component\Form\Extension\Core\Type\TextType', [], Guess::LOW_CONFIDENCE);
        }

        /** @var ClassMetadata $metadata */
        list($metadata, $name) = $ret;

        if ('simple_translation' == $metadata->getTypeOfField($property)) {
            return new TypeGuess(SimpleTranslationType::class, [], Guess::VERY_HIGH_CONFIDENCE);
        }

        return null;
    }

    public function guessRequired($class, $property): ?ValueGuess
    {
        return null;
    }

    public function guessMaxLength($class, $property): ?ValueGuess
    {
        return null;
    }

    public function guessPattern($class, $property): ?ValueGuess
    {
        return null;
    }
}
