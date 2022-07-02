<?php

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;

#[ApiResource(
    collectionOperations: [
        'post' => [
            'status' => Response::HTTP_OK,
        ],
    ],
    itemOperations: [],
    output: BatchTranslationResponse::class,
)]
class BatchTranslationRequest
{
    public function __construct(
        public string $sourceLanguage,
        public string $targetLanguage,
        public array  $sourceTexts,
    )
    {
    }
}
