<?php

namespace App\Dto;

class TranslationResponse
{
    public function __construct(
        public string $sourceLanguage,
        public string $targetLanguage,
        public string $sourceText,
        public string $targetText,
    )
    {
    }
}
