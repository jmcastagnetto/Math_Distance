<?php

namespace Math\Distance;

abstract class Algorithm
{
    /**
     * Abstract method to calculate the distance metric
     *
     * @param mixed $v1
     * @param mixed $v2
     */

    abstract function distance($v1, $v2);

    /**
     * Validates if the parameters are of the expected type and compatibility
     *
     * @param array $v1
     * @param array $v2
     *
     * @throws NonNumericException if the arrays are not numeric
     * @throws IncompatibleItemsException if the arrays are not of the same size
     */

    public function validParameters(array $v1, array $v2)
    {
        $f_num = function ($v, $k)
        {
            if (!is_numeric($v)) {
                throw new NonNumericException(
                'Vectors must contain numeric data, non-numeric item found: '
                . $v);
            }
        };
        // check that each vector member is of numeric type
        array_walk($v1, $f_num);
        array_walk($v2, $f_num);

        // check it both vectors have the same size
        if (count($v1) === count($v2)) {
            return true;
        } else {
            throw new IncompatibleItemsException(
            'Vectors must be of equal size: n1=' . count($v1) . ', n2='
            . count($v2));
        }
    }
}
