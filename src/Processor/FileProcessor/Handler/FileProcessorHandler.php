<?php

declare(strict_types=1);

namespace App\Processor\FileProcessor\Handler;

use App\Processor\FileProcessor\FileProcessorInterface;

class FileProcessorHandler
{

    public function __construct(private iterable $handlers)
    {
    }

    public function handle(string $dataType): FileProcessorInterface
    {
        foreach ($this->handlers as $key => $processor) {
            if ($key === $dataType) {
                return $processor;
            }
        }

        throw new \RuntimeException('No processor found for data type ' . $dataType);
    }
}
