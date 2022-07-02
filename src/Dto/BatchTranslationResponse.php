<?php

namespace App\Dto;

class BatchTranslationResponse
{
    public function __construct(
        public string $sourceLanguage,
        public string $targetLanguage,
        public array  $translatedMap,
    )
    {
    }
}
