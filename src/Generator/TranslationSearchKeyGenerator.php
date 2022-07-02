<?php

namespace App\Generator;

class TranslationSearchKeyGenerator implements TranslationSearchKeyGeneratorInterface
{
    public function generate(string $language, string $text): string
    {
        return hash('sha256', "{$language}_{$text}");
    }
}
