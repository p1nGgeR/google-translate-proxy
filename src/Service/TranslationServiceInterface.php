<?php

namespace App\Service;

use App\Dto\TranslationRequest;
use App\Dto\TranslationResponse;

interface TranslationServiceInterface
{
    public function translateRequest(TranslationRequest $request): TranslationResponse;
}
