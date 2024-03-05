<?php

namespace Softspring\DoctrineSimpleTranslationTypeBundle\Twig\Extension;

use Softspring\DoctrineSimpleTranslationTypeBundle\Model\SimpleTranslation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SimpleTranslationException extends AbstractExtension
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * SimpleTranslationException constructor.
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('translate', [$this, 'translate']),
        ];
    }

    /**
     * @param SimpleTranslation|array $translation
     */
    public function translate($translation, ?string $locale = null): string
    {
        if (is_array($translation)) {
            $translation = SimpleTranslation::createFromArray($translation);
        }

        return $translation->translate($locale ?? $this->getRequest() ? $this->getRequest()->getLocale() : null);
    }

    protected function getRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
