<?php

declare(strict_types=1);

namespace App\Services;

use ErrorException;

/** 
 * Class handles the $data transformation using the $rules provided and $transformers
 * @author Dacian Bujor
 * @package App\Services */
class TransformerService
{

    private array $rules;
    private array $data;
    private array $transformers;
    private const TRANSFORTMER_NAMESPACE = "\\App\Services\Transformers\\";

    public function __construct(array $data, array $rules, array $transformers)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->registerTransformers($transformers);
    }

    /** 
     * Transforms the data using the Rules
     * @return array  */
    public function transformData()
    {
        $output = [];

        foreach ($this->rules as $idx => $rule) {
            $output[$idx] = $this->transform($rule['transformations'], $this->data[$rule['target_column']]);
        }

        return $output;
    }

    /**
     * Register available transformers
     * @param array $transformers 
     * @return void 
     */
    public function registerTransformers(array $transformers): void
    {
        foreach ($transformers as $transformer) {
            $this->transformers[$transformer] = self::TRANSFORTMER_NAMESPACE . ucfirst($transformer);
        }
    }

    /**
     * Get header from $rules data 
     * @return array  */
    public function getOutputHeader(): array
    {
        return array_column($this->rules, 'output_column_name');
    }

    private function transform(array $rules, array $data)
    {
        if (count($rules) > 0) {
            foreach ($rules as $rule) {
                try {
                    $data = $this->transformers[$rule['type']]::execute($data, $rule['options']);
                } catch (ErrorException $e) {
                    echo $e->getMessage() . PHP_EOL;
                    die();
                }
            }
        }
        return $data;
    }
}
