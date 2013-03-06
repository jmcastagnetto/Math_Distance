<?php
namespace Math\Distance;

/**
 * Implements the Manhattan distance algorithm
 *
 * @see Algorithm
 */

class Manhattan extends Algorithm
{
    /**
     * Manhattan (aka "Taxicab") distance metric between two vectors
     *
     * The Manhattan (or Taxicab) distance is defined as the sum of the
     * absolute differences between the vector coordinates, and akin to
     * the type of path that one takes when walking around a city block.
     *
     * This distance is defined as
     * D = SUM( ABS(vector1(i) - vector2(i)) )    (i = 0..k)
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Manhattan_distance
     * - http://xlinux.nist.gov/dads/HTML/manhattanDistance.html
     * - http://mathworld.wolfram.com/TaxicabMetric.html
     *
     * @param array $vector1 first vector
     * @param array $vector2 second vector
     *
     * @throws Distance\NonNumericException if vectors are not numeric
     * @throws Distance\ImcompatibleItemsException if vectors are of dissimilar size
     * @return double The Manhattan distance between vector1 and vector2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws Distance\IncompatibleItemsException
     * @assert (array(3,4,2,1), array(0,5,6,9)) == 16
     * @assert (array(-2,4), array(0,5)) == 3
     *
     */

    public function distance($vector1, $vector2)
    {
        $n = count($vector1);
        $sum = 0;
        for ($i = 0; $i < $n; $i++) {
            $sum += abs($vector1[$i] - $vector2[$i]);
        }
        return $sum;
    }
}
