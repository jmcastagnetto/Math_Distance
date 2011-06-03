<?php
/**
 * @author Jesus M. Castagnetto <jmcastagnetto@php.net>
 *
 */
namespace PEAR2\Math {

    /**
     * Class to compute distance metrics
     *
     */
    class Distance
    {
        /**
         * Private method to check that we got numeric vectors of identical size
         *
         * @param array $v1 first numeric vector
         * @param array $v2 second numeric vector
         * @throws \Exception if vectors are not numeric or dissimilar size
         * @return boolean true if vectors are of same size, false if not
         */
        private static function _compatibleData(array $v1, array $v2)
        {
            // check that each vector member is of numeric type
            foreach ($v1 as $item) {
                if (!is_numeric($item)) {
                    throw new \Exception('Vectors must contain numeric data, non-numeric item found: '.$item);
                }
            }
            foreach ($v2 as $item) {
                if (!is_numeric($item)) {
                    throw new \Exception('Vectors must contain numeric data, non-numeric item found: '.$item);
                }
            }

            // check it both vectors have the same size
            return (count($v1) == count($v2));
        }

        /**
         * Euclidean distance metrics
         *
         * The euclidean distance between two vectors (v1, v2) is defined as
         * D = SQRT(SUM((v1(i) - v2(i))^2))  (i = 0..n)
         *
         * @param array $v1 first vector
         * @param array $v2 second vector
         * @throws \Exception if numeric vectors are of different sizes
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
                throw new \Exception('Incompatible vector sizes');
            }
        }

        public static function minkowski(array $v1, array $v2, $order=0)
        {
            switch ($order) {
                case 0 :
                    throw new \Exception('Minkowski distance order cannot be zero');
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
                        throw new \Exception('Incompatible vector sizes');
                    }
            }
        }

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
                throw new \Exception('Incompatible vector sizes');
            }
        }

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
                throw new \Exception('Incompatible vector sizes');
            }
        }
    }

}

?>