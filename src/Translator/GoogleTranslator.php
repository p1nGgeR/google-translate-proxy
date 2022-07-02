<?php

namespace App\Translator;

use App\Exception\TranslationFailed;
use Google\Cloud\Translate\V2\TranslateClient;
use Psr\Log\LoggerInterface;

class GoogleTranslator implements TranslatorInterface
{
    public function __construct(
        private TranslateClient $translationClient,
        private LoggerInterface $logger
    )
    {
    }

    public function translate(string $sourceLanguage, string $targetLanguage, string $sourceText): string
    {
        try {
            $translationResult = $this->translationClient->translate($sourceText, [
                'source' => $this->getInfluentialPartFromLanguage($sourceLanguage),
                'target' => $this->getInfluentialPartFromLanguage($targetLanguage),
            ]);

            return $this->translationFormatter($translationResult['text']);
        } catch (\Throwable $e) {
            $this->logException($e, compact('sourceLanguage', 'targetLanguage', 'sourceText'));

            throw new TranslationFailed($sourceLanguage, $targetLanguage);
        }
    }

    public function batchTranslate(string $sourceLanguage, string $targetLanguage, array $sourceTexts): array
    {
        try {
            $translations = $this->translationClient->translateBatch($sourceTexts, [
                'target' => $this->getInfluentialPartFromLanguage($targetLanguage),
            ]);

            $translationResult = [];

            foreach ($translations as $translation) {
                $translationResult[$translation['input']] = $this->translationFormatter($translation['text']);
            }

            return $translationResult;
        } catch (\Throwable $e) {
            $this->logException($e, compact('sourceLanguage', 'targetLanguage', 'sourceTexts'));

            throw new TranslationFailed($sourceLanguage, $targetLanguage);
        }
    }

    private function logException(\Exception $exception, array $context): void
    {
        $this->logger->error("'Google Translation Service Error: {$exception->getMessage()}", $context);
    }

    private function getInfluentialPartFromLanguage(string $language): string
    {
        $delimiters = ['-', '_'];

        foreach ($delimiters as $delimiter) {
            if (strpos($language, $delimiter) !== false) {
                $language = explode($delimiter, $language)[0];
            }
        }

        return $language;
    }

    private function translationFormatter(string $text): string
    {
        return html_entity_decode($text, ENT_QUOTES | ENT_HTML5);
    }
}
