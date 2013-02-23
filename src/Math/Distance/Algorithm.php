<?php

namespace Math\Distance;

abstract class Algorithm
{
    /**
     * Abstract method to calculate the distance metric
     *
     * @param mixed $vector1
     * @param mixed $vector2
     */

    abstract function distance($vector1, $vector2);

    /**
     * Validates if the parameters are of the expected type and compatibility
     *
     * @param array $vector1
     * @param array $vector2
     *
     * @throws NonNumericException if the arrays are not numeric
     * @throws IncompatibleItemsException if the arrays are not of the same size
     */

    public function validParameters(array $vector1, array $vector2)
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
        array_walk($vector1, $f_num);
        array_walk($vector2, $f_num);

        // check it both vectors have the same size
        if (count($vector1) === count($vector2)) {
            return true;
        } else {
            throw new IncompatibleItemsException(
            'Vectors must be of equal size: n1=' . count($vector1) . ', n2='
            . count($vector2));
        }
    }
}
