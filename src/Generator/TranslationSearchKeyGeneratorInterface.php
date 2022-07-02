<?php

namespace App\Generator;

interface TranslationSearchKeyGeneratorInterface
{
    public function generate(string $language, string $text): string;
}
