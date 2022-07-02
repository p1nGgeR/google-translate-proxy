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
    output: TranslationResponse::class,
)]
class TranslationRequest
{
    public function __construct(
        public string $sourceLanguage,
        public string $targetLanguage,
        public string $sourceText,
    )
    {
    }
}
