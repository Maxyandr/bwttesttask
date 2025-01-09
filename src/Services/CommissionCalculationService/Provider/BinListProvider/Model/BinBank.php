<?php

declare(strict_types=1);

namespace App\Services\CommissionCalculationService\Provider\BinListProvider\Model;

/**
 * name:"Swedbank Ab"
 */
class BinBank
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
