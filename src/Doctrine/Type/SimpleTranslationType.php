<?php

namespace Softspring\DoctrineSimpleTranslationTypeBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use Softspring\DoctrineSimpleTranslationTypeBundle\Model\SimpleTranslation;

/**
 * Class SimpleTranslationType
 *
 * Search examples:
 *      translated_name->"$.es" LIKE '%text%' AND translated_name->"$._default" = "en"
 *      JSON_CONTAINS(translated_name, '"text"', '$.es');
 */
class SimpleTranslationType extends JsonType
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'simple_translation';
    }

    /**
     * @inheritDoc
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof SimpleTranslation) {
            throw new \RuntimeException(sprintf('Expected %s class, but %s instance received', SimpleTranslation::class, get_class($value)));
        }

        return parent::convertToDatabaseValue($value->__toArray(), $platform);
    }

    /**
     * @inheritDoc
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $data = parent::convertToPHPValue($value, $platform);

        if (empty($data)) {
            return new SimpleTranslation();
        }

        return SimpleTranslation::createFromArray($data);
    }

    /**
     * @inheritDoc
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}