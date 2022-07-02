<?php

namespace App\Translator;

interface TranslatorInterface
{
    public function translate(string $sourceLanguage, string $targetLanguage, string $sourceText): string;

    public function batchTranslate(string $sourceLanguage, string $targetLanguage, array $sourceTexts): array;
}
