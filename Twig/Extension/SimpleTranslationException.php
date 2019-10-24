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
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @inheritDoc
     */
    public function getFilters()
    {
        return [
            new TwigFilter('translate', [$this, 'translate']),
        ];
    }

    /**
     * @param SimpleTranslation $translation
     * @param string|null       $locale
     *
     * @return string
     */
    public function translate(SimpleTranslation $translation, ?string $locale = null): string
    {
        return $translation->translate($locale ?? $this->getRequest()?$this->getRequest()->getLocale() : null);
    }

    /**
     * @return Request|null
     */
    protected function getRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}