<?php

declare(strict_types=1);

namespace App\Processor\FileProcessor\Processor;

use App\Entity\Transaction;
use App\Processor\FileProcessor\FileProcessorInterface;
use Generator;
use Symfony\Component\Serializer\SerializerInterface;

class JsonFileProcessor implements FileProcessorInterface
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    /**
     * Processes the file at the specified path.
     *
     * @param string $filePath The path of the file to process.
     * @return Generator|Transaction Returns a Generator yielding instances of InputData.
     * @throws \Exception
     * @throws \RuntimeException When the file at the specified path cannot be opened.
     */
    public function process(string $filePath): Generator
    {
        // Open the file in read mode
        if (($fileHandler = fopen($filePath, 'r')) === false) {
            throw new \RuntimeException("Failed to open file: $filePath");
        }

        // Iterate through each line of the file
        while (($json = fgets($fileHandler)) !== false) {
            try {
                $inputData = $this->serializer->deserialize(
                    $json,
                    Transaction::class,
                    'json'
                );

                yield $inputData;
            } catch (\Exception $e) {
                fclose($fileHandler);
                throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
            }
        }
        fclose($fileHandler);
    }
}
