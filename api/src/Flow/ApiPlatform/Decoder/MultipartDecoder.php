<?php

namespace App\Flow\ApiPlatform\Decoder;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

// Extracted from API Platform's examples
final class MultipartDecoder implements DecoderInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function decode(string $data, string $format, array $context = []): ?array
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            return null;
        }

        return array_map(static function (mixed $element) {
            // Multipart form values will be encoded in JSON.
            return json_decode($element, true, flags: \JSON_THROW_ON_ERROR);
        }, $request->request->all()) + $request->files->all();
    }

    public function supportsDecoding(string $format): bool
    {
        return 'multipart' === $format;
    }
}
