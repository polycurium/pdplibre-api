<?php

declare(strict_types=1);

namespace App\Flow\Actions;

use App\Flow\Enum\DocType;
use App\Flow\Files\Exception\FileNotFoundException;
use App\Flow\Repository\FlowRepository;
use App\Flow\ValueObjects\FlowFileStream;
use App\Flow\ValueObjects\FlowOutput;
use App\Common\Exception\InvalidInputException;
use App\Common\Exception\ObjectNotFoundException;
use League\Flysystem\FilesystemOperator;

final readonly class GetFlow
{
    public function __construct(
        private FlowRepository $flowRepository,
        private FilesystemOperator $uploadedFilesStorage,
    ) {
    }

    public function __invoke(string $userId, string $flowId, ?string $docTypeInput = null): FlowOutput|FlowFileStream
    {
        $flow = $this->flowRepository->getFlow($flowId, $userId);

        if (!$flow) {
            throw new ObjectNotFoundException('Flow not found');
        }

        try {
            $docType = $docTypeInput ? DocType::from($docTypeInput) : DocType::Metadata;
        } catch (\ValueError $e) {
            throw new InvalidInputException('docType', $e->getMessage());
        }

        return match ($docType) {
            DocType::ReadableView, DocType::Converted => throw new \RuntimeException('TODO'),
            DocType::Original => $this->streamFile($flow->getName()),
            DocType::Metadata => FlowOutput::fromEntity($flow),
        };
    }

    private function streamFile(string $filename): FlowFileStream
    {
        if (!$this->uploadedFilesStorage->fileExists($filename)) {
            throw new FileNotFoundException();
        }

        return new FlowFileStream(
            filename: $filename,
            mimeType: $this->uploadedFilesStorage->mimeType($filename),
            fileSize: $this->uploadedFilesStorage->fileSize($filename),
            stream: $this->uploadedFilesStorage->readStream($filename),
        );
    }
}
