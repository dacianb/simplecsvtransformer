<?php

declare(strict_types=1);

namespace App\Services\Transformers;

use ErrorException;
use App\Services\TransformerInterface;

/** 
 * Class contains date and time transformers
 * @author Dacian Bujor
 * @package App\Services\Transformers */
class Date implements TransformerInterface
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
                    case 'format':
                        $output[$idx] = self::format($value, $options);
                        break;
                    default:
                        throw new ErrorException('Operation: ' . $options['operation'] . ' not found!');
                }
            } else {
                $output[$idx] = '';
            }
        }

        return $output;
    }

    /**
     * Formats date using output_format key
     * @param string $data 
     * @param array $options 
     * @return string 
     */
    private static function format(string $data, array $options)
    {
        return date($options['output_format'], strtotime($data));
    }
}
