<?php

namespace App\Services\CommissionCalculationService\Provider\BinListProvider;

use App\Services\CommissionCalculationService\Provider\BinListProvider\Model\BinData;

interface BinListProviderInterface
{
    public function getBinData(string $bin): BinData;
}
