<?php

declare(strict_types=1);

namespace App\Services\DataSources;

use Exception;
use League\Csv\Reader;
use League\Csv\Writer;
use App\Services\DataSourceInterface;
use ErrorException;


/** 
 * Class for reading and writing CSV files.
 * @author Dacian Bujor
 * @package App\Services\DataSources */
class CSV implements DataSourceInterface
{

    private Reader $reader;
    private Writer $writer;
    private array $records;
    private string $uri;
    private string $filePath;
    private string $baseDir;
    private string $delimiter;

    public function __construct(string $filePath, string $baseDir, string $delimiter = ',')
    {
        if (empty($filePath) || empty($baseDir)) {
            throw new ErrorException('Path not speciffied');
            die();
        }

        $this->filePath = $filePath;
        $this->baseDir = $baseDir;
        $this->delimiter = $delimiter;

        $this->uri = $this->baseDir . '/' . $this->filePath;
    }

    /**
     * Reads the CSV file and returns the data in a row by row array
     * @return array 
     */
    public function readTabularData(): array
    {
        $this->read();
        return $this->records;
    }

    /**
     * Writes data to CSV file in a row by row array
     * @param array $data 
     * @return void 
     */
    public function writeTabularData(array $data): void
    {
        $this->records = $data;
        $this->write();
    }


    /**
     * @return void 
     */
    private function read(): void
    {
        try {
            $this->reader = Reader::createFromPath($this->uri);
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            die();
        }

        $this->reader->setDelimiter($this->delimiter);

        $this->records = iterator_to_array($this->reader->getRecords());
    }

    /**
     * @return void 
     */
    private function write(): void
    {
        try {
            $this->writer = Writer::createFromPath($this->uri, 'w+');
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            die();
        }

        $this->writer->insertAll($this->records);
    }
}
