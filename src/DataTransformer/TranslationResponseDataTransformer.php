<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\TranslationRequest;
use App\Dto\TranslationResponse;
use App\Service\TranslationServiceInterface;

class TranslationResponseDataTransformer implements DataTransformerInterface
{
    public function __construct(private TranslationServiceInterface $translationService)
    {
    }

    public function transform($object, string $to, array $context = [])
    {
        return $this->translationService->translateRequest($object);
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return TranslationResponse::class === $to && $data instanceof TranslationRequest;
    }

}
