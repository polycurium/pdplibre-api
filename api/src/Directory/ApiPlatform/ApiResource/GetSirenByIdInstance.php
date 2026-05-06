<?php

declare(strict_types=1);

namespace App\Directory\ApiPlatform\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\QueryParameter;
use App\Directory\ApiPlatform\StateProvider\GetSirenByIdInstanceProvider;
use App\Directory\ValueObjects\LegalUnitPayloadHistoryOutput;

#[ApiResource(operations: [
    new Get(
        uriTemplate: '/v1/siren/id-instance:{id-instance}',
        outputFormats: ['json'],
        output: LegalUnitPayloadHistoryOutput::class,
        validate: false,
        name: 'getSirenByIdInstance',
        provider: GetSirenByIdInstanceProvider::class,
        parameters: [
            'fields' => new QueryParameter(),
        ],
    ),
])]
final class GetSirenByIdInstance
{
}
