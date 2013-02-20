<?php

namespace Math\Distance;

class Minkowski extends Algorithm
{
    private $_order;
    private $_algo;

    public function __construct($order) {
        $this->order($order);
    }

    public function order($order) {
        if ( $order === 0 ) {
            throw new Exception('Minkowski distance order cannot be zero');
        } elseif ( $order === 1 ) {
            $this->_algo = "Manhattan";
        } elseif ( $order === 2 ) {
            $this->_algo = "Euclidean";
        }
        $this->_order = $order;
    }

    /**
     * Minkowski distance metric between two vectors
     *
     * The Minkowski distance is a generalization of the a metric in
     * Euclidean space and includes as special cases the Euclidean,
     * Manhattan and Chebyshev distances.
     *
     * It is also known as the Lp metric (where p is the metric order)
     *
     * This distance is defined as
     * D = (SUM((v1(i) - v2(i))^p))^(1/p) (i = 0..k)
     * where: p = 1..n
     * when p = 1 => reduces to the Manhattan distance
     * when p = 2 => reduces to the Euclidean distance
     * when p -> infinite => reduces to the Chebyshev distance
     *
     * Refs:
     * - http://en.wikipedia.org/wiki/Minkowski_distance
     * - http://xlinux.nist.gov/dads/HTML/lmdistance.html
     * - http://goo.gl/AktXh (Article at code10.info)
     *
     * @param double $order	the Lp metric
     * @param array  $v1	first vector
     * @param array  $v2	second vector
     *
     * @throws Distance\NonNumericException if vectors are not numeric
     * @throws Distance\ImcompatibleItemsException if vectors are of dissimilar size
     * @return double The Minkowski distance of the given order between v1 and v2
     * @see _compatibleData()
     *
     * @assert (array(1,2,3), array(1,2,3,4), 2) throws Distance\IncompatibleItemsException
     * @assert (array(0,5,6,9), array(3,4,2,1), 0) throws Distance\Distance\Exception
     * @assert (array(0,5,6,9), array(3,4,2,1), 1) == 16
     * @assert (array(0,5,6,9), array(3,4,2,1), 3) == pow(pow(3,3)+pow(-1,3)+pow(4,3)+pow(-8,3),1/3)
     * @assert (array(0,5,6,9), array(3,4,2,1), 4) == pow(pow(3,3)+pow(-1,3)+pow(4,3)+pow(-8,3),1/4)
     *
     */
    public function distance($v1, $v2)
    {
        if (in_array($this->_algo, array("Euclidean", "Manhattan"))) {
            $d = new $this->_algo;
            return $d->distance($v1, $v2);
        } else{
            $n = count($v1);
            $sum = 0;
            for ($i=0; $i < $n; $i++) {
                $sum += pow(abs($v1[$i] - $v2[$i]), $this->_order);
            }
            return pow($sum, 1/$this->_order);
        }
    }
}
