<?php

declare(strict_types=1);

namespace App\Services\DataSources;

use App\Services\DataSourceInterface;


/** 
 * @todo Implement
 * @package App\Services\DataSources */
class API implements DataSourceInterface
{

    public function readTabularData(): array
    {
        return [];
    }

    public function writeTabularData(array $data): void
    {
    }
}
