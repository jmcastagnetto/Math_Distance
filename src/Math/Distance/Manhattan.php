<?php
namespace Math\Distance;

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
     * D = SUM( ABS(v1(i) - v2(i)) )    (i = 0..k)
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Manhattan_distance
     * - http://xlinux.nist.gov/dads/HTML/manhattanDistance.html
     * - http://mathworld.wolfram.com/TaxicabMetric.html
     *
     * @param array $v1 first vector
     * @param array $v2 second vector
     *
     * @throws Distance\NonNumericException if vectors are not numeric
     * @throws Distance\ImcompatibleItemsException if vectors are of dissimilar size
     * @return double The Manhattan distance between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws Distance\IncompatibleItemsException
     * @assert (array(3,4,2,1), array(0,5,6,9)) == 16
     * @assert (array(-2,4), array(0,5)) == 3
     *
     */
    public function distance($v1, $v2)
    {
        $n = count($v1);
        $sum = 0;
        for ($i=0; $i < $n; $i++) {
            $sum += abs($v1[$i] - $v2[$i]);
        }
        return $sum;
    }
}
