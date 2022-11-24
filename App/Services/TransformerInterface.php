<?php

declare(strict_types=1);

namespace App\Services;

/** 
 * Implemented on all transformers
 * @author Dacian Bujor
 * @package App\Services */
interface TransformerInterface
{

    /**
     * Execute transformation
     * @param array $data 
     * @param array $options 
     * @return array 
     */
    public static function execute(array $data, array $options): array;
}
