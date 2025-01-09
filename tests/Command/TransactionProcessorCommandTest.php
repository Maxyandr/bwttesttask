<?php

namespace App\Tests\Command;

use App\Command\TransactionProcessorCommand;
use App\Entity\Transaction;
use App\Processor\FileProcessor\Enum\FileTypes;
use App\Processor\FileProcessor\FileProcessorInterface;
use App\Processor\FileProcessor\Handler\FileProcessorHandler;
use App\Services\CommissionCalculationService\CommissionCalculationService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TransactionProcessorCommandTest extends TestCase
{
    private $fileProcessorHandlerMock;
    private $comissionCalculationServiceMock;

    protected function setUp(): void
    {
        $this->fileProcessorHandlerMock = $this->createMock(FileProcessorHandler::class);
        $this->comissionCalculationServiceMock = $this->createMock(CommissionCalculationService::class);
    }

    public function testExecuteWithInvalidDataType(): void
    {
        $inputMock = $this->createMock(InputInterface::class);
        $outputMock = $this->createMock(OutputInterface::class);

        $inputMock->method('getArgument')->with('file_path')->willReturn('/path/to/file');
        $inputMock->method('getOption')->with('data_type')->willReturn('invalid_type');

        $outputMock->expects($this->once())
            ->method('writeln')
            ->with($this->stringContains('Invalid data type specified'));

        $command = new TransactionProcessorCommand($this->fileProcessorHandlerMock, $this->comissionCalculationServiceMock);
        $result = $command->run($inputMock, $outputMock);
        $this->assertEquals(Command::FAILURE, $result);
    }

    public function testExecuteWithValidDataType(): void
    {
        $filePath = '/path/to/file';
        $dataType = FileTypes::JSON_ROW->value;
        $transactionMock = $this->createMock(Transaction::class);

        $inputMock = $this->createMock(InputInterface::class);
        $outputMock = $this->createMock(OutputInterface::class);

        $fileProcessorMock = $this->createMock(FileProcessorInterface::class);

        $inputMock->method('getArgument')->with('file_path')->willReturn($filePath);
        $inputMock->method('getOption')->with('data_type')->willReturn($dataType);

        $this->fileProcessorHandlerMock->expects($this->once())
            ->method('handle')
            ->with($dataType)
            ->willReturn($fileProcessorMock);

        $fileProcessorMock->method('process')
            ->with($filePath)
            ->willReturn((function () use ($transactionMock) {
                yield $transactionMock;
            })());

        $this->comissionCalculationServiceMock->expects($this->once())
            ->method('calculateCommission')
            ->with($transactionMock)
            ->willReturn('10.00');

        $outputMock->expects($this->once())
            ->method('writeln')
            ->with($this->stringContains('Comission: 10.00'));

        $command = new TransactionProcessorCommand(
            $this->fileProcessorHandlerMock,
            $this->comissionCalculationServiceMock
        );

        $result = $command->run($inputMock, $outputMock);

        $this->assertEquals(Command::SUCCESS, $result);
    }
}
