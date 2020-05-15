<?php

declare(strict_types=1);

namespace App\Utils;

use Traversable;

/**
 * Class ArrayTools
 * @package App\Utils
 */
class ArrayTools
{
    /**
     * Разбивает итерируемый объект на части
     *
     * @param iterable $data
     * @param int $chunkSize
     * @return Traversable
     */
    public static function chunk(iterable $data, int $chunkSize): Traversable
    {
        $batchArray = [];
        foreach ($data as $item) {
            $batchArray[] = $item;
            if (count($batchArray) >= $chunkSize) {
                yield $batchArray;
                $batchArray = [];
            }
        }

        if (count($batchArray) > 0) {
            yield $batchArray;
        }
    }
}
