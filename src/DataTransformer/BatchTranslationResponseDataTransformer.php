<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\BatchTranslationRequest;
use App\Dto\BatchTranslationResponse;
use App\Service\BatchTranslationServiceInterface;

class BatchTranslationResponseDataTransformer implements DataTransformerInterface
{
    public function __construct(private BatchTranslationServiceInterface $translationService)
    {
    }

    public function transform($object, string $to, array $context = [])
    {
        return $this->translationService->translateBatchRequest($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return BatchTranslationResponse::class === $to && $data instanceof BatchTranslationRequest;
    }

}
