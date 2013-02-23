<?php

namespace Math\Distance;

class Euclidean extends Algorithm
{
    /**
     * Euclidean distance metric between two vectors
     *
     * The euclidean distance between two vectors (v1, v2) is defined as
     * D = SQRT(SUM((v1(i) - v2(i))^2))  (i = 0..k)
     *
     * Refs:
     * - http://mathworld.wolfram.com/EuclideanMetric.html
     * - http://en.wikipedia.org/wiki/Euclidean_distance
     *
     * @param array $v1 first vector
     * @param array $v2 second vector
     *
     * @throws Distance\NonNumericException if vectors are not numeric
     * @throws Distance\ImcompatibleItemsException if vectors are of dissimilar size
     * @return double The Euclidean distance between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4)) throws Distance\IncompatibleItemsException
     * @assert (array(2,'a',6,7), array(4,5,1,9)) throws Distance\NonNumericException
     * @assert (array(1,2), array(3,4)) == sqrt(8)
     * @assert (array(2,4,6,7), array(4,5,1,9)) == sqrt(4+1+25+4)
     *
     */

    public function distance($v1, $v2)
    {
        $n = count($v1);
        $sum = 0;
        for ($i = 0; $i < $n; $i++) {
            $sum += ($v1[$i] - $v2[$i]) * ($v1[$i] - $v2[$i]);
        }
        return sqrt($sum);
    }
}
