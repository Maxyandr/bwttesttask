<?php

namespace App\Command;

use App\Entity\Transaction;
use App\Processor\FileProcessor\Enum\FileTypes;
use App\Processor\FileProcessor\Handler\FileProcessorHandler;
use App\Services\CommissionCalculationService\CommissionCalculationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'transaction:processor',
    description: 'Processes transactions from file and calculate comissions.',
)]
class TransactionProcessorCommand extends Command
{
    public function __construct(
        private FileProcessorHandler         $fileProcessorHandler,
        private CommissionCalculationService $comissionCalculationService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file_path', InputArgument::REQUIRED, 'Path to file with transactions')
            ->addOption('data_type', 't', InputOption::VALUE_OPTIONAL, 'Type of data in file', FileTypes::JSON_ROW->value)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('file_path');

        $dataType = $input->getOption('data_type');
        if (!FileTypes::tryFrom($dataType)) {
            $output->writeln(sprintf('Invalid data type specified: %s', $dataType));
            return Command::FAILURE;
        }

        $fileProcessor = $this->fileProcessorHandler->handle($dataType);

        /** @var Transaction $transaction */
        foreach ($fileProcessor->process($filePath) as $transaction) {
            $commission = $this->comissionCalculationService->calculateCommission($transaction);
            $output->writeln(sprintf('Comission: %s', $commission));
        }

        return Command::SUCCESS;
    }
}
