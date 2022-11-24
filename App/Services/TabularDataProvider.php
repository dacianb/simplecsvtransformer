<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\DataSourceInterface;

/** 
 * Provides a common way to access and manipulate tabular data
 * @author Dacian Bujor
 * @package App\Services */
class TabularDataProvider
{

    private array $data;
    private array $dataHeader;
    private int $headerOffset;

    public function __construct(DataSourceInterface $reader, int $headerOffset = null)
    {
        $this->data = $reader->readTabularData();
        $this->headerOffset = $headerOffset;

        $this->init();
    }

    /**
     * Get tabular data 
     * @param bool $withHeader 
     * @return array 
     */
    public function getData(bool $withHeader = false): array
    {
        if ($withHeader) {
            array_unshift($this->data, $this->dataHeader);
        }
        return $this->data;
    }


    /**
     * Set tabular data
     * @param array $data 
     * @return void 
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }



    /**
     * Converts the data form rows/columns
     * @param string $to 
     * @return void 
     */
    public function convert(string $to)
    {
        if ($to == 'rows') {
            $this->convertToRows();
        }
        if ($to == 'columns') {
            $this->convertToColumns();
        }
    }

    private function convertToColumns(bool $assoc = false): void
    {
        $output = [];

        foreach ($this->data as $rowData) {
            foreach ($rowData as $column => $value) {
                if ($assoc) {
                    $output[$this->dataHeader[$column]][] = $value;
                } else {
                    $output[$column][] = $value;
                }
            }
        }

        $this->data = $output;
    }

    private function convertToRows(bool $assoc = false): void
    {
        $output = [];

        foreach ($this->data as $idx => $column) {
            foreach ($column as $row => $value) {
                if ($assoc) {
                    $output[$row][$this->dataHeader[$idx]] = $value;
                } else {
                    $output[$row][] = $value;
                }
            }
        }

        $this->data = $output;
    }


    /** 
     * Get header data
     * @return array  */
    public function getHeader(): array
    {
        return $this->dataHeader;
    }

    /**
     * Set header data
     * @param array $header 
     * @return void 
     */
    public function setHeader(array $header): void
    {
        $this->dataHeader = $header;
    }


    /** 
     * Sets the header data with regard of $headerOffset
     * @return void  */
    private function init(): void
    {
        if ($this->headerOffset !== null) {
            $this->dataHeader = $this->data[$this->headerOffset];
            unset($this->data[$this->headerOffset]);
        }
    }
}
