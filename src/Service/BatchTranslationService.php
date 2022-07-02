<?php

namespace App\Service;

use App\Dto\BatchTranslationRequest;
use App\Dto\BatchTranslationResponse;
use App\Entity\Translation;
use App\Repository\TranslationRepository;
use App\Translator\TranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class BatchTranslationService implements BatchTranslationServiceInterface
{
    public function __construct(
        private TranslationRepository  $translationRepository,
        private TranslatorInterface    $translator,
        private EntityManagerInterface $em,
    )
    {
    }

    public function translateBatchRequest(BatchTranslationRequest $request): BatchTranslationResponse
    {
        // TODO
    }
}
