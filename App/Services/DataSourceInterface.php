<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Every data source class needs to implement this method!
 * @author Dacian Bujor 
 * @package App\Services */
interface DataSourceInterface
{

    /**
     * Returns tabular data from data source row by row
     * @return array 
     */
    public function readTabularData(): array;

    /**
     * Writes tabular data to data source row by row
     * @param array $data 
     * @return void 
     */
    public function writeTabularData(array $data): void;
}
