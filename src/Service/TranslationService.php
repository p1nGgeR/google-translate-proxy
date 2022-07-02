<?php

namespace App\Service;

use App\Dto\TranslationRequest;
use App\Dto\TranslationResponse;
use App\Entity\Translation;
use App\Repository\TranslationRepository;
use App\Translator\TranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class TranslationService implements TranslationServiceInterface
{
    public function __construct(
        private TranslationRepository  $translationRepository,
        private TranslatorInterface    $translator,
        private EntityManagerInterface $em,
    )
    {
    }

    public function translateRequest(TranslationRequest $request): TranslationResponse
    {
        $sourceTranslation = $this->translationRepository
            ->findOrCreateTranslation($request->sourceLanguage, $request->sourceText);
        $targetTranslation = $sourceTranslation->getTranslationForLanguage($request->targetLanguage);

        if (!$targetTranslation) {
            $targetTranslation = $this->translate($sourceTranslation, $request->targetLanguage);
        }

        $this->em->flush();

        return new TranslationResponse(
            $sourceTranslation->getLanguage(),
            $targetTranslation->getLanguage(),
            $sourceTranslation->getText(),
            $targetTranslation->getText(),
        );
    }

    private function translate(Translation $translation, string $targetLanguage): Translation
    {
        $targetText = $this->translator->translate(
            $translation->getLanguage(),
            $targetLanguage,
            $translation->getText()
        );

        $targetTranslation = $this->translationRepository->findOrCreateTranslation($targetLanguage, $targetText);

        $translation->addTranslation($targetTranslation);
        $this->em->persist($translation);

        return $targetTranslation;
    }
}
