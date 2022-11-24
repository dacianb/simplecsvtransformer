<?php

declare(strict_types=1);

namespace App;

use App\Services\TransformerService;
use App\Services\DataSources\CSV;
use App\Services\TabularDataProvider;

/** 
 * This class acts as a general data flow controller
 * @author Dacian Bujor
 * @package App */
class App
{

    private string $baseDir;
    private array $rules;
    private string $inputFilePath;
    private string $outputFilePath;
    private string $inputDelimiter;
    private int $inputHeaderOffset;

    private string $shortFlags = 'i:o:';
    private array $longFlags = [
        'input-delimiter::',
        'input-header-offset:',
        'output-delimiter:',
    ];

    private array $transformers = [
        'math',
        'str',
        'date'
    ];


    public function __construct(string $baseDir, array $transformationRules)
    {
        $this->baseDir = $baseDir;
        $this->rules = $transformationRules;

        $this->parseCLIArgs();
    }

    /**
     * This is where the magic happens :)
     * @return void 
     */
    public function run(): void
    {
        //Creating the CSV object used for reading the data
        $inputCSV = new CSV($this->inputFilePath, $this->baseDir, $this->inputDelimiter);

        //Creating the Tabular Data object for processing the data
        $tabularData = new TabularDataProvider($inputCSV, $this->inputHeaderOffset);

        //Converting the data in a columns oriented array
        $tabularData->convert('columns');

        //Creating the Transformer Service object for transforming the data
        $transformer = new TransformerService($tabularData->getData(), $this->rules, $this->transformers);

        //Transforming the data
        $transformedData = $transformer->transformData();

        //Setting the output header
        $tabularData->setHeader($transformer->getOutputHeader());

        //Replacing the original data with the transformed data
        $tabularData->setData($transformedData);

        //Converting the data in rows oriented array
        $tabularData->convert('rows');

        //Creating the CSV object used for writing the data
        $outputCSV = new CSV($this->outputFilePath, $this->baseDir, $this->outputDelimiter);

        //Writing the data to file
        $outputCSV->writeTabularData($tabularData->getData(true));
    }


    /** 
     * Parse input flags
     * @todo Create a dedicated class for hadeling CLI parsing and validation
     * @return void  */
    private function parseCLIArgs(): void
    {
        $arguments = getopt($this->shortFlags, $this->longFlags);

        $this->inputFilePath = $arguments['i'];
        $this->outputFilePath = $arguments['o'];
        $this->inputDelimiter = $arguments['input-delimiter'];
        $this->inputHeaderOffset = (int)$arguments['input-header-offset'] ?? null;
        $this->outputDelimiter = $arguments['output-delimiter'] ?? $arguments['input-delimiter'];
    }
}
