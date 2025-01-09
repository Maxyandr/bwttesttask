<?php

declare(strict_types=1);

namespace App\Processor\FileProcessor\Processor;

use App\Entity\Transaction;
use App\Processor\FileProcessor\FileProcessorInterface;
use Generator;

class CsvFileProcessor implements FileProcessorInterface
{
    /**
     * Processes the file at the specified path.
     *
     * @param string $filePath The path of the file to process.
     * @return Generator|Transaction Returns a Generator yielding instances of InputData.
     * @throws \RuntimeException When the file at the specified path cannot be opened.
     */
    public function process(string $filePath): Generator
    {
        // Open the file in read mode
        if (($fileHandler = fopen($filePath, 'r')) === false) {
            throw new \RuntimeException("Failed to open file: $filePath");
        }

        // Iterate through each line of the file
        while (($data = fgetcsv($fileHandler)) !== false) {
            $inputData = new Transaction();
            // Assuming the csv file consist of bin, amount, currency in the same order
            $inputData->setBin($data[0]);
            $inputData->setAmount($data[1]);
            $inputData->setCurrency($data[2]);
            // Yield InputData instance
            yield $inputData;
        }
        fclose($fileHandler);
    }
}
