<?php

namespace Math\Distance;

/**
 * Implements the Chebyshev distance algorithm
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
     * D = MAX( ABS(vector1(i) - vector2(i)) )  (i = 0..k)
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Chebyshev_distance
     *
     * @param array $vector1 first vector
     * @param array $vector2 second vector
     *
     * @throws IncompatibleItemsException if numeric vectors are of different sizes
     * @throws NonNumericException if vectors are not numeric
     * @return double The Chebyshev distance between vector1 and vector2
     */

    public function distance($vector1, $vector2)
    {
        $n = count($vector1);
        $diffvals = array();
        for ($i = 0; $i < $n; $i++) {
            $diffvals[$i] = abs($vector1[$i] - $vector2[$i]);
        }
        return max($diffvals);
    }

}
