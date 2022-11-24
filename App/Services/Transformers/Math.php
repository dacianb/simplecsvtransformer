<?php

declare(strict_types=1);

namespace App\Services\Transformers;

use ErrorException;
use App\Services\TransformerInterface;


/** 
 * Class contains math transformers
 * @todo Add data type validation
 * @author Dacian Bujor
 * @package App\Services\Transformers */
class Math implements TransformerInterface
{
    /**
     * @param array $data 
     * @param array $options 
     * @return array 
     * @throws ErrorException 
     */
    public static function execute(array $data, array $options): array
    {
        $output = [];

        foreach ($data as $idx => $value) {
            if (!empty($value)) {
                switch ($options['operation']) {
                    case 'add':
                        $output[$idx] = self::add((float)$value, (float)$options['by']);
                        break;
                    case 'subtract':
                        $output[$idx] = self::subtract((float)$value, (float)$options['by']);
                        break;
                    case 'multiply':
                        $output[$idx] = self::multiply((float)$value, (float)$options['by']);
                        break;
                    case 'devide':
                        $output[$idx] = self::devide((float)$value, (float)$options['by']);
                        break;
                    default:
                        throw new ErrorException('Math operator: ' . $options['operation'] . ' not allowed');
                }
            } else {
                $output[$idx] = '';
            }
        }

        return $output;
    }

    private static function add(float $a, float $b)
    {
        return $a + $b;
    }

    private static function subtract(float $a, float $b)
    {
        return $a - $b;
    }

    private static function multiply(float $a, float $b)
    {
        return $a * $b;
    }

    private static function devide(float $a, float $b)
    {
        return $a / $b;
    }
}
