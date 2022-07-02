<?php

namespace App\Service;

use App\Dto\BatchTranslationRequest;
use App\Dto\BatchTranslationResponse;

interface BatchTranslationServiceInterface
{
    public function translateBatchRequest(BatchTranslationRequest $request): BatchTranslationResponse;
}
