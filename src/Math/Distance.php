<?php
/**
 * @author Jesus M. Castagnetto <jmcastagnetto@php.net>
 *
 */
namespace PEAR2\Math {

    /**
     * Class to compute common distance metrics
     *
     * It implements methods to compute the Euclidean, Minkowski, Manhattan and Chebyshev metrics
     *
     * $v1 = array(0,2,4,5);
     * $v2 = array(1,4,7,2);
     *
     * $e = PEAR2\Math\Distance::euclidean($v1, $v2);
     * $m = PEAR2\Math\Distance::minkowski($v1, $v2);
     * $t = PEAR2\Math\Distance::manhattan($v1, $v2);
     * $c = PEAR2\Math\Distance::chebyshev($v1, $v2);
     *
     */
    class Distance
    {
        /**
         * Private method to check whether we got numeric vectors of identical size
         *
         * @param array $v1 first numeric vector
         * @param array $v2 second numeric vector
         * @throws \PEAR2\Math\Distance\Exception if vectors are not numeric or dissimilar size
         * @return boolean true if vectors are of same size, false if not
         */
        private static function _compatibleData(array $v1, array $v2)
        {
            // check that each vector member is of numeric type
            foreach ($v1 as $item) {
                if (!is_numeric($item)) {
                    throw new \PEAR2\Math\Distance\Exception('Vectors must contain numeric data, non-numeric item found: '.$item);
                }
            }
            foreach ($v2 as $item) {
                if (!is_numeric($item)) {
                    throw new \PEAR2\Math\Distance\Exception('Vectors must contain numeric data, non-numeric item found: '.$item);
                }
            }
            // check it both vectors have the same size
            return (count($v1) == count($v2));
        }

        /**
         * Euclidean distance metric between two vectors
         *
         * The euclidean distance between two vectors (v1, v2) is defined as
         * D = SQRT(SUM((v1(i) - v2(i))^2))  (i = 0..n)
         *
         * Refs:
         * - http://mathworld.wolfram.com/EuclideanMetric.html
         * - http://en.wikipedia.org/wiki/Euclidean_distance
         *
         * @param array $v1 first vector
         * @param array $v2 second vector
         * @throws \PEAR2\Math\Distance\Exception if numeric vectors are of different sizes
         * @return The euclidean distance between v1 and v2
         * @see _compatibleData()
         *
         */
        public static function euclidean(array $v1, array $v2)
        {
            if (Distance::_compatibleData($v1, $v2)) {
                $n = count($v1);
                $sum = 0;
                for ($i=0; $i < $n; $i++) {
                    $sum = ($v1[$i] - $v2[$i]) * ($v1[$i] - $v2[$i]);
                }
                return sqrt($sum);
            } else {
                throw new \PEAR2\Math\Distance\Exception('Incompatible vector sizes');
            }
        }

        /**
         * Minkowski distance metric between two vectors
         *
         * @param $v1
         * @param $v2
         * @param $order
         */
        public static function minkowski(array $v1, array $v2, $order=0)
        {
            switch ($order) {
                case 0 :
                    throw new \PEAR2\Math\Distance\Exception('Minkowski distance order cannot be zero');
                    break;
                case 1 :
                    return Distance::manhattan($v1, $v2);
                    break;
                case 2 :
                    return Distance::euclidean($v1, $v2);
                    break;
                default :
                    $order = (double) $order;
                    if (Distance::_compatibleData($v1, $v2)) {
                        $n = count($v1);
                        $sum = 0;
                        for ($i=0; $i < $n; $i++) {
                            $sum = power(($v1[$i] - $v2[$i]), 2);
                        }
                        return power($sum, 1/$order);
                    } else {
                        throw new \PEAR2\Math\Distance\Exception('Incompatible vector sizes');
                    }
            }
        }

        /**
         * Manhattak (aka "Taxicab") distance metric between two vectors
         *
         * @param $v1
         * @param $v2
         */
        public static function manhattan($v1, $v2)
        {
            if (Distance::_compatibleData($v1, $v2)) {
                $n = count($v1);
                $sum = 0;
                for ($i=0; $i < $n; $i++) {
                    $sum = abs($v1[$i] - $v2[$i]);
                }
                return $sum;
            } else {
                throw new \PEAR2\Math\Distance\Exception('Incompatible vector sizes');
            }
        }

        /**
         * Chenyshev disntance metric between two vectors
         *
         *
         * @param unknown_type $v1
         * @param unknown_type $v2
         */
        public static function chebyshev($v1, $v2)
        {
            if (Distance::_compatibleData($v1, $v2)) {
                $n = count($v1);
                $diffvals = array();
                for ($i=0; $i < $n; $i++) {
                    $diffvals[$i] = abs($v1[$i] - $v2[$i]);
                }
                return max($diffvals);
            } else {
                throw new \PEAR2\Math\Distance\Exception('Incompatible vector sizes');
            }
        }

        /**
         * Hamming distance between two strings
         *
         * @param string $s1
         * @param string $s2
         * @throws \PEAR2\Math\Distance\Exception if parameters are not strings of the same length
         * @return integer the hamming length from s1 to s2
         */
        public static function hamming($s1, $s2)
        {
            if ((is_string($s1) && is_string($s2)) && (strlen($s1) == strlen($s2))) {
                $res = array_diff_assoc(str_split($s1), str_split($s2));
                return count($res);
            } else {
                throw \PEAR2\Math\Distance\Exception('Expecting two strings of equal lenght');
            }
        }
    }

    // echo Distance::hamming('1011101','1001001')."\n";
}

?>