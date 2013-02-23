<?php

namespace Math\Distance;

/**
 * Class: Chebyshev
 *
 * @see Algorithm
 */
class Chebyshev extends Algorithm
{
    /**
     * Chebyshev distance metric between two vectors
     *
     * The Chebyshev distance aka the Maximum metric (L[inf])
     * is the greatest of their differences along any coordinate.
     *
     * This distance is defined as
     * D = MAX( ABS(v1(i) - v2(i)) )  (i = 0..k)
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Chebyshev_distance
     *
     * @param array $v1 first vector
     * @param array $v2 second vector
     *
     * @throws IncompatibleItemsException if numeric vectors are of different sizes
     * @throws NonNumericException if vectors are not numeric
     * @return double The Chebyshev distance between v1 and v2
     */

    public function distance($v1, $v2)
    {
        $n = count($v1);
        $diffvals = array();
        for ($i = 0; $i < $n; $i++) {
            $diffvals[$i] = abs($v1[$i] - $v2[$i]);
        }
        return max($diffvals);
    }

}
