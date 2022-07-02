<?php

namespace App\Exception;

class TranslationFailed extends \Exception
{
    public function __construct(string $sourceLanguage, string $targetLanguage)
    {
        parent::__construct("Failed to translate from `{$sourceLanguage}` to `{$targetLanguage}`");
    }
}
