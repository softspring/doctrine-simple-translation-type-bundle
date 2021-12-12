<?php

namespace Softspring\DoctrineSimpleTranslationTypeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SfsDoctrineSimpleTranslationTypeBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}