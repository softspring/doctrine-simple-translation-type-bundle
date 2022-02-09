<?php

namespace Softspring\DoctrineSimpleTranslationTypeBundle\Model;

/**
 * Class SimpleTranslation.
 */
class SimpleTranslation implements \ArrayAccess
{
    /**
     * @var array
     */
    protected $translations = [];

    /**
     * @var string
     */
    protected $defaultLocale = 'en';

    /**
     * @return SimpleTranslation
     */
    public static function createFromArray(array $data)
    {
        $simpleTranslation = new SimpleTranslation();
        $simpleTranslation->defaultLocale = $data['_default'];
        unset($data['_default']);
        $simpleTranslation->translations = $data;

        return $simpleTranslation;
    }

    public function __toArray(): array
    {
        return [
            '_default' => $this->defaultLocale,
        ] + $this->translations;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }

    public function setTranslations(array $translations): void
    {
        $this->translations = $translations;
    }

    public function setTranslation(?string $locale, string $translation): void
    {
        $this->translations[$locale ?? $this->getDefaultLocale()] = $translation;
    }

    public function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }

    public function setDefaultLocale(string $defaultLocale): void
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @param string $locale
     */
    public function translate(string $locale = null): string
    {
        if (!empty($this->translations[$locale])) {
            return $this->translations[$locale];
        }

        if (!empty($this->translations[$this->defaultLocale])) {
            return $this->translations[$this->defaultLocale];
        }

        return '';
    }

    public function offsetExists($offset)
    {
        return true;
    }

    public function offsetGet($offset)
    {
        return $this->translations[$offset] ?? '';
    }

    public function offsetSet($offset, $value)
    {
        $this->translations[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->translations[$offset]);
    }
}
