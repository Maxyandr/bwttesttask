<?php

declare(strict_types=1);

namespace App\Processor\FileProcessor;

interface FileProcessorInterface
{
    public function process(string $filePath): \Generator;
}
