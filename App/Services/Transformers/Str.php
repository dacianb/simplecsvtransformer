<?php

declare(strict_types=1);

namespace App\Services\Transformers;

use ErrorException;
use App\Services\TransformerInterface;

/** 
 * Class contains string transformers
 * @todo Add data type validation
 * @author Dacian Bujor
 * @package App\Services\Transformers */
class Str implements TransformerInterface
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
                    case 'replace':
                        $output[$idx] = self::replace((string)$value, $options);
                        break;
                    case 'str_to_lower':
                        $output[$idx] = self::str_to_lower((string)$value);
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

    private static function replace(string $data, array $options): string
    {

        switch ($options['condition']) {
            case 'equal':
                if ($data == $options['value']) {
                    $data = (string)$options['replace_with'];
                }
                break;
            case 'not-equal':
                if ($data !== $options['value']) {
                    $data = (string)$options['replace_with'];
                }
                break;
        }
        return $data;
    }

    private static function str_to_lower(string $data): string
    {
        return strToLower($data);
    }
}
